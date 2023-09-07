	<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;


RL_SetConfigFlags( RL_FLAG_MSAA_4X_HINT );
RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [shapes] example - cubic-bezier lines" );

$START = RL_Vector2( 0.0 , 0.0 );
$END   = RL_Vector2( $SCREEN_W , $SCREEN_H );

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_LEFT ) )
	{
		$START = RL_GetMousePosition();
	}
	else
	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_RIGHT ) )
	{
		$END = RL_GetMousePosition();
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( "USE MOUSE LEFT-RIGHT CLICK to DEFINE LINE START and END POINTS" , 15 , 20 , 20 , RL_GRAY );

		RL_DrawLineBezier( $START , $END , 2.0 , RL_RED );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
