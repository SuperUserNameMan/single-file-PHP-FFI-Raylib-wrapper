<?php
//TAB=4

require("./raylib/raylib.ffi.php");

$SCREEN_WIDTH  = 800 ;
$SCREEN_HEIGHT = 450 ;

RL_InitWindow( $SCREEN_WIDTH , $SCREEN_HEIGHT , "raylib [core] example - keyboard input" );


$BALL_POSITION = RL_Vector2( $SCREEN_WIDTH / 2.0 , $SCREEN_HEIGHT / 2.0 );


RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	// UPDATE :

	if ( RL_IsKeyDown( RL_KEY_RIGHT ) ) $BALL_POSITION->x += 2.0 ;
	if ( RL_IsKeyDown( RL_KEY_LEFT  ) ) $BALL_POSITION->x -= 2.0 ;
	if ( RL_IsKeyDown( RL_KEY_UP    ) ) $BALL_POSITION->y -= 2.0 ;
	if ( RL_IsKeyDown( RL_KEY_DOWN  ) ) $BALL_POSITION->y += 2.0 ;


	// DRAW :

	RL_BeginDrawing();

		RL_ClearBackground( RL_WHITE );

		RL_DrawText( "move the ball with arrow keys" , 10 , 10 , 20 , RL_DARKGRAY );

		RL_DrawCircleV( $BALL_POSITION , 50 , RL_MAROON );

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
