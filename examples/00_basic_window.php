<?php
//TAB=4

require("./raylib/raylib.ffi.php");

$SCREEN_WIDTH  = 800 ;
$SCREEN_HEIGHT = 450 ;

RL_InitWindow( $SCREEN_WIDTH , $SCREEN_HEIGHT , "raylib [core] example - basic window" );

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	// UPDATE :

	// ... your variables here ...

	// DRAW :

	RL_BeginDrawing();

		RL_ClearBackground( RL_WHITE );

		RL_DrawText( "Congrats! You created your first window!" , 190 , 200 , 20 , RL_LIGHTGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
