<?php
//TAB=4


include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - drop files" );

$FILE_PATHES = [] ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsFileDropped() )
	{
		$DROPPED_FILES = RL_LoadDroppedFiles();

		for( $i = 0 ; $i < $DROPPED_FILES->count ; $i++ )
		{
			$FILE_PATHES[] = FFI::string( $DROPPED_FILES->paths[ $i ] ); //XXX
		}

		RL_UnloadDroppedFiles( $DROPPED_FILES );    // Unload filepaths from memory
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		if ( count( $FILE_PATHES )== 0 )
		{
			RL_DrawText( "Drop your files to this window!" , 100 , 40 , 20 , RL_DARKGRAY );
		}
		else
		{
			RL_DrawText( "Dropped files:" , 100 , 40 , 20 , RL_DARKGRAY );

			for( $i = 0 ; $i < count( $FILE_PATHES ) ; $i++ )
			{
				if ( $i % 2 == 0 )
				{
					RL_DrawRectangle( 0 , 85 + 40*$i , $SCREEN_W , 40, RL_Fade( RL_LIGHTGRAY , 0.5 ) );
				}
				else
				{
					RL_DrawRectangle( 0 , 85 + 40*$i , $SCREEN_W , 40 , RL_Fade( RL_LIGHTGRAY , 0.3 ) );
				}

				RL_DrawText( $FILE_PATHES[ $i ] , 120 , 100 + 40*$i , 10 , RL_GRAY );
			}

			RL_DrawText( "Drop new files..." , 100 , 110 + 40*count( $FILE_PATHES ) , 20 , RL_DARKGRAY );
		}

	RL_EndDrawing();
}


RL_CloseWindow();

//EOF
