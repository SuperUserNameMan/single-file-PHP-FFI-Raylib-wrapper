<?php
//TAB=4

include('./raylib/raylib.ffi.php');


$RAYGUI_IS_MISSING = ! RL_SUPPORT_MODULE_RAYGUI ;

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [shapes] example - draw ring" );

$CENTER = RL_Vector2
(
	( RL_GetScreenWidth() - 300 ) / 2.0 ,
	RL_GetScreenHeight() / 2.0
);

$INNER_RADIUS =  80.0 ;
$OUTER_RADIUS = 190.0 ;

$START_ANGLE = 0.0 ;
$END_ANGLE = 360.0 ;
$SEGMENTS = 0.0 ;

$DRAW_RING         = true ;
$DRAW_RING_LINES   = false ;
$DRAW_CIRCLE_LINES = false ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawLine( 500 , 0 , 500 , RL_GetScreenHeight() , RL_Fade( RL_LIGHTGRAY , 0.6 ) );
		RL_DrawRectangle( 500 , 0 , RL_GetScreenWidth() - 500 , RL_GetScreenHeight() , RL_Fade( RL_LIGHTGRAY , 0.3 ) );

		if ( $DRAW_RING         ) RL_DrawRing             ( $CENTER , $INNER_RADIUS , $OUTER_RADIUS , $START_ANGLE , $END_ANGLE , (int)$SEGMENTS , RL_Fade( RL_MAROON , 0.3 ) );
		if ( $DRAW_RING_LINES   ) RL_DrawRingLines        ( $CENTER , $INNER_RADIUS , $OUTER_RADIUS , $START_ANGLE , $END_ANGLE , (int)$SEGMENTS , RL_Fade( RL_BLACK  , 0.4 ) );
		if ( $DRAW_CIRCLE_LINES ) RL_DrawCircleSectorLines( $CENTER , $OUTER_RADIUS ,                 $START_ANGLE , $END_ANGLE , (int)$SEGMENTS , RL_Fade( RL_BLACK  , 0.4 ) );

		// Draw GUI controls
		//------------------------------------------------------------------------------
		if ( $RAYGUI_IS_MISSING )
		{
			$TEXT_LINES = [
				[ "This example requires", 20 , RL_MAROON ] ,
				[ "RAYGUI", 30 , RL_Color( rand()%255 , rand()%255, rand()%255 , 255 ) ] ,
				[ "compiled inside", 20 , RL_MAROON ],
				[ basename( $_RAYLIB_PATH ) , 20 , RL_BLACK ] ,
			];

			$X_CENTER = 500 + ( RL_GetScreenWidth() - 500 ) / 2 ;

			$Y_LINE = 100 ;

			foreach( $TEXT_LINES as $LINE )
			{
				list( $TEXT , $SIZE , $COLOR ) = $LINE ;
				$WIDTH = RL_MeasureText( $TEXT , $SIZE );
				RL_DrawText( $TEXT , $X_CENTER - $WIDTH/2 , $Y_LINE , $SIZE , $COLOR );
				$Y_LINE += $SIZE * 2 ;
			}
		}
		else
		{
			$START_ANGLE = RL_GuiSliderBar( RL_Rectangle( 600 ,  40 , 120 , 20 ) , "StartAngle" , '' , $START_ANGLE , -450 , 450 );
			$END_ANGLE   = RL_GuiSliderBar( RL_Rectangle( 600 ,  70 , 120 , 20 ) , "EndAngle"   , '' , $END_ANGLE   , -450 , 450 );

			$INNER_RADIUS = RL_GuiSliderBar( RL_Rectangle( 600 , 140 , 120 , 20 ) , "InnerRadius", '' , $INNER_RADIUS , 0 , 100 );
			$OUTER_RADIUS = RL_GuiSliderBar( RL_Rectangle( 600 , 170 , 120 , 20 ) , "OuterRadius", '' , $OUTER_RADIUS , 0 , 200 );

			$SEGMENTS = RL_GuiSliderBar( RL_Rectangle( 600 , 240 , 120 , 20 ) , "Segments"   , '' , $SEGMENTS , 0 , 100 );

			$DRAW_RING         = RL_GuiCheckBox( RL_Rectangle( 600 , 320 , 20 , 20 ) , "Draw Ring" , $DRAW_RING );
			$DRAW_RING_LINES   = RL_GuiCheckBox( RL_Rectangle( 600 , 350 , 20 , 20 ) , "Draw RingLines" , $DRAW_RING_LINES );
			$DRAW_CIRCLE_LINES = RL_GuiCheckBox( RL_Rectangle( 600 , 380 , 20 , 20 ) , "Draw CircleLines" , $DRAW_CIRCLE_LINES );

			$MIN_SEGMENTS = (int)ceil( ( $END_ANGLE - $START_ANGLE ) /90 );

			RL_DrawText( RL_TextFormat( "MODE: %s" , ($SEGMENTS >= $MIN_SEGMENTS )? "MANUAL" : "AUTO") , 600 , 270 , 10 , ($SEGMENTS >= $MIN_SEGMENTS )? RL_MAROON : RL_DARKGRAY );
		}

		RL_DrawFPS(10, 10);

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
