<?php
//TAB=4

require("./raylib/raylib.ffi.php");

$SCREEN_WIDTH  = 800 ;
$SCREEN_HEIGHT = 450 ;

RL_InitWindow( $SCREEN_WIDTH , $SCREEN_HEIGHT , "raylib [core] example - input mouse wheel" );


$BOX_POSITION_Y = $SCREEN_HEIGHT / 2 - 40;
$SCROLL_SPEED   = 4 ;


RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	// UPDATE :

	$BOX_POSITION_Y -= RL_GetMouseWheelMove() * $SCROLL_SPEED ;

	// DRAW :

	RL_BeginDrawing();

		RL_ClearBackground( RL_WHITE );

		RL_DrawRectangle( $SCREEN_WIDTH / 2 - 40 , $BOX_POSITION_Y , 80 , 80 , RL_MAROON );

		RL_DrawText( "Use mouse wheel to move the cube up and down!" , 10 , 10 , 20 , RL_GRAY );
		RL_DrawText( RL_TextFormat( "Box position Y: %03i", (int)$BOX_POSITION_Y ) , 10 , 40 , 20 , RL_LIGHTGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
