<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - window should close" );

RL_SetExitKey( RL_KEY_NULL ); // Disable KEY_ESCAPE to close window, X-button still works

$EXIT_WINDOW_REQUESTED = false ;
$EXIT_WINDOW_NOW       = false ;

RL_SetTargetFPS( 60 );

while( ! $EXIT_WINDOW_NOW )
{

	// Detect if X-button or KEY_ESCAPE have been pressed to close window
	if ( RL_WindowShouldClose() || RL_IsKeyPressed( RL_KEY_ESCAPE ) )
	{
		$EXIT_WINDOW_REQUESTED = true ;
	}

	if ( $EXIT_WINDOW_REQUESTED )
	{
		// A request for close window has been issued, we can save data before closing
		// or just show a message asking for confirmation

		if ( RL_IsKeyPressed( RL_KEY_Y ) )
		{
			$EXIT_WINDOW_NOW = true ;
		}
		else
		if ( RL_IsKeyPressed( RL_KEY_N ) )
		{
			$EXIT_WINDOW_REQUESTED = false ;
		}
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		if ( $EXIT_WINDOW_REQUESTED )
		{
			RL_DrawRectangle( 0 , 100 , $SCREEN_W , 200 , RL_BLACK );
			RL_DrawText( "Are you sure you want to exit program? [Y/N]" , 40 , 180 , 30 , RL_WHITE );
		}
		else
		{
			RL_DrawText( "Try to close the window to get confirmation message!" , 120 , 200 , 20 , RL_LIGHTGRAY );
		}

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
