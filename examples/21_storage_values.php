<?php
//TAB=4


include('./raylib/raylib.ffi.php');


define( 'STORAGE_DATA_FILE' ,  "storage.data" );

// NOTE: Storage positions must start with 0, directly related to file memory layout
define( 'STORAGE_POSITION_SCORE'  , 0 );
define( 'STORAGE_POSITION_HISCORE' , 1 );


$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - storage save/load values" );

$SCORE = 0 ;
$HISCORE = 0 ;
$FRAMES_COUNTER = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsKeyPressed( RL_KEY_R ) )
	{
		$SCORE   = RL_GetRandomValue( 1000 , 2000 );
		$HISCORE = RL_GetRandomValue( 2000 , 4000 );
	}

	if ( RL_IsKeyPressed( RL_KEY_ENTER ) )
	{
		SaveStorageValue( STORAGE_POSITION_SCORE  , $SCORE   );
		SaveStorageValue( STORAGE_POSITION_HISCORE, $HISCORE );
	}
	else
	if ( RL_IsKeyPressed( RL_KEY_SPACE ) )
	{
		// NOTE: If requested position could not be found, value 0 is returned
		$SCORE   = LoadStorageValue( STORAGE_POSITION_SCORE   );
		$HISCORE = LoadStorageValue( STORAGE_POSITION_HISCORE );
	}

	$FRAMES_COUNTER++;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( RL_TextFormat( "SCORE: %i"    , (int)$SCORE   ) , 280 , 130 , 40 , RL_MAROON );
		RL_DrawText( RL_TextFormat( "HI-SCORE: %i" , (int)$HISCORE ) , 210 , 200 , 50 , RL_BLACK  );

		RL_DrawText( RL_TextFormat( "frames: %i"   , (int)$FRAMES_COUNTER ) , 10 , 10 , 20 , RL_LIME );

		RL_DrawText( "Press R to generate random numbers" , 220 , 40 , 20 , RL_LIGHTGRAY );
		RL_DrawText( "Press ENTER to SAVE values" , 250 , 310 , 20 , RL_LIGHTGRAY );
		RL_DrawText( "Press SPACE to LOAD values" , 252 , 350 , 20 , RL_LIGHTGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();

// Save integer value to storage file (to defined position)
// NOTE: Storage positions is directly related to file memory layout (4 bytes each integer)
function SaveStorageValue( int $POSITION , int $VALUE ) : bool
{
	$SUCCESS       = false ;
	$DATA_SIZE     = 0 ;
	$NEW_DATA_SIZE = 0 ;

	$FILE_DATA = RL_LoadFileData( STORAGE_DATA_FILE , $DATA_SIZE );
	$NEW_FILE_DATA = null ;

	$SIZEOF_INT_TYPE = FFI::sizeof( FFI::type('int') );

	if ( ! is_null( $FILE_DATA ) )
	{
		if ( $DATA_SIZE <= ( $POSITION * $SIZEOF_INT_TYPE ) )
		{
			// Increase data size up to position and store value
			$NEW_DATA_SIZE = ( $POSITION + 1 ) * $SIZEOF_INT_TYPE ;
			$NEW_FILE_DATA = RL_MemRealloc( $FILE_DATA , $NEW_DATA_SIZE );

			if ( $NEW_FILE_DATA != NULL )
			{
				$DATA_PTR = FFI::cast( 'int*' , $NEW_FILE_DATA );
				$DATA_PTR[ $POSITION ] = $VALUE ;
			}
			else
			{
				RL_TraceLog
				(
					RL_LOG_WARNING ,
					"FILEIO: [%s] Failed to realloc data (%u), position in bytes (%u) bigger than actual file size" ,
					STORAGE_DATA_FILE ,
					(int)$DATA_SIZE ,
					(int)($POSITION * $SIZEOF_INT_TYPE)
				);

				// We store the old size of the file
				$NEW_FILE_DATA = $FILE_DATA ;
				$NEW_DATA_SIZE = $DATA_SIZE ;
			}
		}
		else
		{
			// Store the old size of the file
			$NEW_FILE_DATA = $FILE_DATA ;
			$NEW_DATA_SIZE = $DATA_SIZE ;

			// Replace value on selected position
			$DATA_PTR = FFI::cast( 'int*' , $NEW_FILE_DATA );
			$DATA_PTR[ $POSITION ] = $VALUE ;
		}

		$SUCCESS = RL_SaveFileData( STORAGE_DATA_FILE , $NEW_FILE_DATA , $NEW_DATA_SIZE );
		RL_MemFree( $NEW_FILE_DATA );

		RL_TraceLog( RL_LOG_INFO , "FILEIO: [%s] Saved storage value: %i" , STORAGE_DATA_FILE , (int)$VALUE );
	}
	else
	{
		RL_TraceLog( RL_LOG_INFO , "FILEIO: [%s] File created successfully" , STORAGE_DATA_FILE );

		$DATA_SIZE = ( $POSITION + 1 ) * $SIZEOF_INT_TYPE ;
		$FILE_DATA = RL_MemAlloc( $DATA_SIZE );
		$DATA_PTR = FFI::cast( 'int*' , $FILE_DATA );
		$DATA_PTR[ $POSITION ] = $VALUE ;

		$SUCCESS = RL_SaveFileData( STORAGE_DATA_FILE , $FILE_DATA , $DATA_SIZE );
		RL_UnloadFileData( $FILE_DATA );

		RL_TraceLog( RL_LOG_INFO , "FILEIO: [%s] Saved storage value: %i" , STORAGE_DATA_FILE , (int)$VALUE );
	}

	return $SUCCESS ;
}

// Load integer value from storage file (from defined position)
// NOTE: If requested position could not be found, value 0 is returned
function LoadStorageValue( int $POSITION ) : int
{
	$VALUE     = 0 ;
	$DATA_SIZE = 0 ;
	$FILE_DATA = RL_LoadFileData( STORAGE_DATA_FILE , $DATA_SIZE );

	if ( ! is_null( $FILE_DATA ) )
	{
		if ( $DATA_SIZE < ( $POSITION*4) )
		{
			RL_TraceLog( RL_LOG_WARNING, "FILEIO: [%s] Failed to find storage position: %i" , STORAGE_DATA_FILE , $POSITION );
		}
		else
		{
			$DATA_PTR = FFI::cast( 'int*' , $FILE_DATA );
			$VALUE    = $DATA_PTR[ $POSITION ];
		}

		RL_UnloadFileData( $FILE_DATA );

		RL_TraceLog( RL_LOG_INFO, "FILEIO: [%s] Loaded storage value: %i" , STORAGE_DATA_FILE , $VALUE );
	}

	return $VALUE ;
}

//EOF
