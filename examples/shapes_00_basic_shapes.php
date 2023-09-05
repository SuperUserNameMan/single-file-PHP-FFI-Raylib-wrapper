<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [shapes] example - basic shapes drawing" );

$ROTATION = 0.0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$ROTATION += 0.2 ;


	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( "some basic shapes available on raylib" , 20 , 20 , 20 , RL_DARKGRAY );

	// Circle shapes and lines
		$X = $SCREEN_W/5 ;
		RL_DrawCircle        ( $X , 120 , 35 , RL_DARKBLUE );
		RL_DrawCircleGradient( $X , 220 , 60 , RL_GREEN , RL_SKYBLUE );
		RL_DrawCircleLines   ( $X , 340 , 80 , RL_DARKBLUE );

	// Rectangle shapes and lines
		$X = $SCREEN_W/4 * 2 ;
		RL_DrawRectangle         ( $X - 60 , 100 , 120 ,  60 , RL_RED );
		RL_DrawRectangleGradientH( $X - 90 , 170 , 180 , 130 , RL_MAROON , RL_GOLD );
		RL_DrawRectangleLines    ( $X - 40 , 320 ,  80 ,  60 , RL_ORANGE );  // NOTE: Uses QUADS internally, not lines

	// Triangle shapes and lines
		$X = $SCREEN_W/4 * 3 ;
		RL_DrawTriangle
		(
			RL_Vector2( $X        ,  80.0 ) ,
			RL_Vector2( $X - 60.0 , 150.0 ) ,
			RL_Vector2( $X + 60.0 , 150.0 ) ,
			RL_VIOLET
		);

		RL_DrawTriangleLines
		(
			RL_Vector2( $X        , 160.0 ) ,
			RL_Vector2( $X - 20.0 , 230.0 ) ,
			RL_Vector2( $X + 20.0 , 230.0 ) ,
			RL_DARKBLUE
		);

	// Polygon shapes and lines
		$X = $SCREEN_W/4 * 3 ;
		RL_DrawPoly       ( RL_Vector2( $X , 330 ) , 6 , 80 , $ROTATION , RL_BROWN );
		RL_DrawPolyLines  ( RL_Vector2( $X , 330 ) , 6 , 90 , $ROTATION , RL_BROWN );
		RL_DrawPolyLinesEx( RL_Vector2( $X , 330 ) , 6 , 85 , $ROTATION , 6 , RL_BEIGE );

	// NOTE: We draw all LINES based shapes together to optimize internal drawing,
	// this way, all LINES are rendered in a single draw pass
		RL_DrawLine( 18 , 42 , $SCREEN_W - 18 , 42 , RL_BLACK );

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
