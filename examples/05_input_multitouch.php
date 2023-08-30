<?php
//TAB=4

require("./raylib/raylib.ffi.php");

define( 'MAX_TOUCH_POINTS' , 10 );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - input multitouch" );

$TOUCH_POSITIONS = RL_Vector2_array( MAX_TOUCH_POINTS );

RL_SetTargetFPS( 60 );

while ( ! RL_WindowShouldClose() )
{
	$TOUCH_COUNT = min( RL_GetTouchPointCount() , MAX_TOUCH_POINTS );

	for( $i = 0 ; $i < $TOUCH_COUNT ; $i++ )
	{
		$TOUCH_POSITIONS[ $i ] = RL_GetTouchPosition( $i );
	}

	RL_BeginDrawing();

	RL_ClearBackground( RL_RAYWHITE );

	for( $i = 0 ; $i < $TOUCH_COUNT ; $i++ )
	{
		// Make sure point is not (0, 0) as this means there is no touch for it
		if ( ( $TOUCH_POSITIONS[ $i ]->x > 0 ) && ( $TOUCH_POSITIONS[ $i ]->y > 0 ) )
		{
			// Draw circle and touch index number
			RL_DrawCircleV( $TOUCH_POSITIONS[ $i ] , 34 , RL_ORANGE );
			RL_DrawText( RL_TextFormat( "%d" , $i ) ,
				(int)$TOUCH_POSITIONS[ $i ]->x - 10 ,
				(int)$TOUCH_POSITIONS[ $i ]->y - 70 ,
				40, RL_BLACK );
		}
	}

	RL_DrawText( "touch the screen at multiple locations to get multiple balls" , 10 , 10 , 20 , RL_DARKGRAY );

	RL_DrawText( "THIS PHP EXAMPLE IS UNTESTED ON REAL HARDWARE" , 10 , $SCREEN_H - 30 , 20 , RL_RED );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
