<?php
//TAB=4

include('./raylib/raylib.ffi.php');


enum GAME_SCREEN
{
	case LOGO ;
	case TITLE ;
	case GAMEPLAY ;
	case ENDING ;
}

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - basic screen manager" );

$CURRENT_SCREEN = GAME_SCREEN::LOGO ;

$FRAMES_COUNTER = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	switch( $CURRENT_SCREEN )
	{
		case GAME_SCREEN::LOGO :
		{
			// TODO: Update LOGO screen variables here!

			$FRAMES_COUNTER++;

			// Switch to TITLE after 2 seconds
			if ( $FRAMES_COUNTER > 120 )
			{
				$CURRENT_SCREEN = GAME_SCREEN::TITLE ;
			}
		}
		break;

		case GAME_SCREEN::TITLE :
		{
			// TODO: Update TITLE screen variables here!

			if ( RL_IsKeyPressed( RL_KEY_ENTER ) || RL_IsGestureDetected( RL_GESTURE_TAP ) )
			{
				$CURRENT_SCREEN = GAME_SCREEN::GAMEPLAY ;
			}
		}
		break;

		case GAME_SCREEN::GAMEPLAY :
		{
			// TODO: Update GAMEPLAY screen variables here!

			if ( RL_IsKeyPressed( RL_KEY_ENTER ) || RL_IsGestureDetected( RL_GESTURE_TAP ) )
			{
				$CURRENT_SCREEN = GAME_SCREEN::ENDING ;
			}
		}
		break;

		case GAME_SCREEN::ENDING :
		{
			// TODO: Update ENDING screen variables here!

			if ( RL_IsKeyPressed( RL_KEY_ENTER) || RL_IsGestureDetected( RL_GESTURE_TAP ) )
			{
				$CURRENT_SCREEN = GAME_SCREEN::TITLE ;
			}
		}
		break;

		default: break;
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		switch( $CURRENT_SCREEN )
		{
			case GAME_SCREEN::LOGO :
			{
				// TODO: Draw LOGO screen here!
				RL_DrawText( "LOGO SCREEN" , 20 , 20 , 40 , RL_LIGHTGRAY );
				RL_DrawText( "WAIT for 2 SECONDS..." , 290 , 220 , 20 , RL_GRAY );
			}
			break;

			case GAME_SCREEN::TITLE :
			{
				// TODO: Draw TITLE screen here!
				RL_DrawRectangle( 0 , 0 , $SCREEN_W , $SCREEN_H , RL_GREEN );
				RL_DrawText( "TITLE SCREEN" , 20 , 20 , 40 , RL_DARKGREEN );
				RL_DrawText( "PRESS ENTER or TAP to JUMP to GAMEPLAY SCREEN" , 120 , 220 , 20 , RL_DARKGREEN );
			}
			break;

			case GAME_SCREEN::GAMEPLAY :
			{
				// TODO: Draw GAMEPLAY screen here!
				RL_DrawRectangle( 0 , 0 , $SCREEN_W , $SCREEN_H , RL_PURPLE );
				RL_DrawText( "GAMEPLAY SCREEN" , 20 , 20 , 40 , RL_MAROON );
				RL_DrawText( "PRESS ENTER or TAP to JUMP to ENDING SCREEN" , 130 , 220 , 20 , RL_MAROON );
			}
			break;

			case GAME_SCREEN::ENDING :
			{
				// TODO: Draw ENDING screen here!
				RL_DrawRectangle( 0 , 0 , $SCREEN_W , $SCREEN_H , RL_BLUE );
				RL_DrawText( "ENDING SCREEN" , 20 , 20 , 40 , RL_DARKBLUE );
				RL_DrawText( "PRESS ENTER or TAP to RETURN to TITLE SCREEN" , 120 , 220 , 20 , RL_DARKBLUE );
			}
			break;

			default: break;
		}

	RL_EndDrawing();
}

// TODO: Unload all loaded data (textures, fonts, audio) here!

RL_CloseWindow();

//EOF
