<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;


RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - scissor test" );

$SCISSOR_AREA = RL_Rectangle( 0 , 0 , 300 , 300 );
$SCISSOR_MODE = true ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsKeyPressed( RL_KEY_S ) )
	{
		$SCISSOR_MODE = ! $SCISSOR_MODE ;
	}

	$SCISSOR_AREA->x = RL_GetMouseX() - $SCISSOR_AREA->width  / 2 ;
	$SCISSOR_AREA->y = RL_GetMouseY() - $SCISSOR_AREA->height / 2 ;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		if ( $SCISSOR_MODE )
		{
			RL_BeginScissorMode( $SCISSOR_AREA->x , $SCISSOR_AREA->y , $SCISSOR_AREA->width , $SCISSOR_AREA->height );
		}

			// Draw full screen rectangle and some text
			// NOTE: Only part defined by scissor area will be rendered
			RL_DrawRectangle( 0 , 0 , RL_GetScreenWidth() , RL_GetScreenHeight() , RL_RED );
			RL_DrawText( "Move the mouse around to reveal this text!" , 190 , 200 , 20 , RL_LIGHTGRAY );

		if ( $SCISSOR_MODE )
		{
			RL_EndScissorMode();
		}

		RL_DrawRectangleLinesEx( $SCISSOR_AREA , 1 , RL_BLACK );
		RL_DrawText( "Press S to toggle scissor test" , 10 , 10 , 20 , RL_BLACK );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
