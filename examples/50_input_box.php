<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAX_INPUT_CHARS' , 9 );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [text] example - input box" );

$NAME = "" ;
$LETTER_COUNT = 0 ;

$TEXT_BOX = RL_Rectangle( $SCREEN_W/2.0 - 150.0 , 180.0 , 300.0 , 50.0 );
$MOUSE_ON_TEXT = false ;

$FRAME_COUNTER = 0 ;

RL_SetTargetFPS( 10 );

while( ! RL_WindowShouldClose() )
{
	$MOUSE_ON_TEXT = RL_CheckCollisionPointRec( RL_GetMousePosition() , $TEXT_BOX );

	if ( $MOUSE_ON_TEXT )
	{
		// Set the window's cursor to the I-Beam
		RL_SetMouseCursor( RL_MOUSE_CURSOR_IBEAM );

		// Check if more characters have been pressed on the same frame
		while( 0 < ( $KEY = RL_GetCharPressed() ) )
		{
			// NOTE: Only allow keys in range [32..125] (ASCII)
			if ( $KEY <  32 ) continue ;
			if ( $KEY > 125 ) continue ;

			if ( $LETTER_COUNT >= MAX_INPUT_CHARS ) continue ;

			$NAME .= chr( $KEY );
			$LETTER_COUNT++;
		}

		if ( RL_IsKeyPressed( RL_KEY_BACKSPACE ) && $LETTER_COUNT > 0 )
		{
			$LETTER_COUNT--;
			$NAME = substr( $NAME , 0 , $LETTER_COUNT );
		}
	}
	else
	{
		RL_SetMouseCursor( RL_MOUSE_CURSOR_DEFAULT );
	}

	if ( $MOUSE_ON_TEXT ) $FRAME_COUNTER++;
	else $FRAME_COUNTER = 0;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		$T = "PLACE MOUSE OVER INPUT BOX!" ;
		RL_DrawText( $T , ( $SCREEN_W - RL_MeasureText( $T , 20 ) ) / 2 , 140 , 20 , RL_GRAY );

		RL_DrawRectangleRec( $TEXT_BOX , RL_LIGHTGRAY );

		$COLOR = ( $MOUSE_ON_TEXT ) ? RL_RED : RL_DARKGRAY ;
		RL_DrawRectangleLines( (int)$TEXT_BOX->x , (int)$TEXT_BOX->y , (int)$TEXT_BOX->width , (int)$TEXT_BOX->height , $COLOR );

		RL_DrawText( $NAME , (int)$TEXT_BOX->x + 5 , (int)$TEXT_BOX->y + 8 , 40 , RL_MAROON );

		RL_DrawText( RL_TextFormat( "INPUT CHARS: %i/%i" , $LETTER_COUNT , MAX_INPUT_CHARS ) , 315 , 250 , 20 , RL_DARKGRAY );

		if ( $MOUSE_ON_TEXT )
		{
			if ( $LETTER_COUNT < MAX_INPUT_CHARS)
			{
				// Draw blinking underscore char
				if ( ( intdiv( $FRAME_COUNTER , 5 ) % 2 ) == 0 )
				{
					RL_DrawText( "_" , (int)$TEXT_BOX->x + 8 + RL_MeasureText( $NAME , 40 ) , (int)$TEXT_BOX->y + 12 , 40 , RL_MAROON);
				}
			}
			else
			{
				RL_DrawText( "Press BACKSPACE to delete chars..." , 230 , 300 , 20 , RL_GRAY );
			}
		}

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
