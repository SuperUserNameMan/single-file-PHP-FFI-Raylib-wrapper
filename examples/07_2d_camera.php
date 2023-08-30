<?php
//TAB=4

include( './raylib/raylib.ffi.php' );


define( 'MAX_BUILDINGS' , 100 );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 2d camera" );

$PLAYER = RL_Rectangle( 400 , 280 , 40 , 40 );

$BUILDINGS = RL_Rectangle_array( MAX_BUILDINGS );
$BUILDINGS_COLORS = RL_Color_array( MAX_BUILDINGS );

$SPACING = 0 ;

for( $i = 0 ; $i < MAX_BUILDINGS ; $i++ )
{
	$BUILDINGS[ $i ]->width  = RL_GetRandomValue(  50 , 200 );
	$BUILDINGS[ $i ]->height = RL_GetRandomValue( 100 , 800 );
	$BUILDINGS[ $i ]->y      = $SCREEN_H - 130.0 - $BUILDINGS[ $i ]->height ;
	$BUILDINGS[ $i ]->x      = -6_000.0 + $SPACING ;

	$SPACING += $BUILDINGS[ $i ]->width ;

	$BUILDINGS_COLORS[ $i ] = RL_Color(
		RL_GetRandomValue( 200 , 240 ) ,
		RL_GetRandomValue( 200 , 240 ) ,
		RL_GetRandomValue( 200 , 250 ) ,
		255 );
}

$CAMERA = RL_Camera2D();

$CAMERA->target   = RL_Vector2( $PLAYER->x + 20.0 , $PLAYER->y + 20.0 );
$CAMERA->offset   = RL_Vector2( $SCREEN_W / 2.0 , $SCREEN_H / 2.0 );
$CAMERA->rotation = 0.0 ;
$CAMERA->zoom     = 1.0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if     ( RL_IsKeyDown( RL_KEY_RIGHT ) ) $PLAYER->x += 2 ;
	elseif ( RL_IsKeyDown( RL_KEY_LEFT  ) ) $PLAYER->x -= 2 ;

	$CAMERA->target->x = $PLAYER->x + 20 ;
	$CAMERA->target->y = $PLAYER->y + 20 ;

	if     ( RL_IsKeyDown( RL_KEY_A ) ) $CAMERA->rotation-- ;
	elseif ( RL_IsKeyDown( RL_KEY_S ) ) $CAMERA->rotation++ ;

	// Limit camera rotation to 80 degrees (-40 to 40)
	if     ( $CAMERA->rotation >  40 ) $CAMERA->rotation =  40 ;
	elseif ( $CAMERA->rotation < -40 ) $CAMERA->rotation = -40 ;

	// Camera zoom controls
	$CAMERA->zoom += (float)RL_GetMouseWheelMove() * 0.05 ;

	if     ( $CAMERA->zoom > 3.0 ) $CAMERA->zoom = 3.0 ;
	elseif ( $CAMERA->zoom < 0.1 ) $CAMERA->zoom = 0.1 ;

	// Camera reset (zoom and rotation)
	if ( RL_IsKeyPressed( RL_KEY_R ) )
	{
		$CAMERA->zoom     = 1.0 ;
		$CAMERA->rotation = 0.0 ;
	}


	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode2D( $CAMERA );

		RL_DrawRectangle( -6000 , 320 , 13000 , 8000 , RL_DARKGRAY );

		for( $i = 0 ; $i < MAX_BUILDINGS ; $i++) RL_DrawRectangleRec( $BUILDINGS[ $i ] , $BUILDINGS_COLORS[ $i ] );

		RL_DrawRectangleRec( $PLAYER , RL_RED );

		RL_DrawLine( $CAMERA->target->x , -$SCREEN_H*10 , $CAMERA->target->x , $SCREEN_H*10 , RL_GREEN );
		RL_DrawLine( -$SCREEN_W*10 , $CAMERA->target->y , $SCREEN_W*10 , $CAMERA->target->y , RL_GREEN );

	RL_EndMode2D();

	RL_DrawText( "SCREEN AREA" , 640 , 10 , 20 , RL_RED );

	RL_DrawRectangle( 0 , 0 , $SCREEN_W , 5 , RL_RED );
	RL_DrawRectangle( 0 , 5 , 5 , $SCREEN_H - 10 , RL_RED);
	RL_DrawRectangle( $SCREEN_W - 5 , 5 , 5 , $SCREEN_H - 10 , RL_RED );
	RL_DrawRectangle( 0 , $SCREEN_H - 5 , $SCREEN_W , 5 , RL_RED );

	RL_DrawRectangle( 10 , 10 , 250 , 113 , RL_Fade( RL_SKYBLUE , 0.5 ) );
	RL_DrawRectangleLines( 10 , 10 , 250 , 113 , RL_BLUE );

	RL_DrawText( "Free 2d camera controls:" , 20 , 20 , 10 , RL_BLACK );
	RL_DrawText( "- Right/Left to move Offset" , 40 , 40 , 10 , RL_DARKGRAY );
	RL_DrawText( "- Mouse Wheel to Zoom in-out" , 40 , 60 , 10 , RL_DARKGRAY );
	RL_DrawText( "- A / S to Rotate" , 40 , 80 , 10 , RL_DARKGRAY );
	RL_DrawText( "- R to reset Zoom and Rotation" , 40 , 100 , 10 , RL_DARKGRAY );

	RL_EndDrawing();
}


RL_CloseWindow();

// EOF
