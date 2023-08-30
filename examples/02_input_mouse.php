<?php
//TAB=4

require("./raylib/raylib.ffi.php");

$SCREEN_WIDTH  = 800 ;
$SCREEN_HEIGHT = 450 ;

RL_InitWindow( $SCREEN_WIDTH , $SCREEN_HEIGHT , "raylib [core] example - mouse input" );


$BALL_POSITION = RL_Vector2( -100.0 , -100.0 );
$BALL_COLOR    = RL_DARKBLUE ;


RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	// UPDATE :

	$BALL_POSITION = RL_GetMousePosition();

	if     ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_LEFT    ) ) $BALL_COLOR = RL_MAROON ;
	elseif ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_MIDDLE  ) ) $BALL_COLOR = RL_LIME ;
	elseif ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_RIGHT   ) ) $BALL_COLOR = RL_DARKBLUE ;
	elseif ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_SIDE    ) ) $BALL_COLOR = RL_PURPLE ;
	elseif ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_EXTRA   ) ) $BALL_COLOR = RL_YELLOW ;
	elseif ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_FORWARD ) ) $BALL_COLOR = RL_ORANGE ;
	elseif ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_BACK    ) ) $BALL_COLOR = RL_BEIGE ;

	// DRAW :

	RL_BeginDrawing();

		RL_ClearBackground( RL_WHITE );

		RL_DrawCircleV( $BALL_POSITION , 40 , $BALL_COLOR );

		RL_DrawText( "move ball with mouse and click mouse button to change color" , 10 , 10 , 20 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
