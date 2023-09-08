<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] examples - texture source and destination rectangles" );

$TEXTURE = RL_LoadTexture( "./raylib/examples/resources/ugly.png" ); // contains 6 frames

$FRAME_W = $TEXTURE->width / 6 ; // width of a single frame
$FRAME_H = $TEXTURE->height ;

// Source rectangle (part of the texture to use for drawing)
$SRC_RECT = RL_Rectangle( 0.0 , 0.0 , $FRAME_W , $FRAME_H );

// Destination rectangle (screen rectangle where drawing part of texture)
$DST_RECT = RL_Rectangle( $SCREEN_W/2.0 , $SCREEN_H/2.0 , $FRAME_W*2.0 , $FRAME_H*2.0 );

// Origin of the texture (rotation/scale point), it's relative to destination rectangle size
$ORIGIN = RL_Vector2( $FRAME_W , $FRAME_H );

$ROTATION = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$ROTATION++ ;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		// NOTE: Using DrawTexturePro() we can easily rotate and scale the part of the texture we draw
		// sourceRec defines the part of the texture we use for drawing
		// destRec defines the rectangle where our texture part will fit (scaling it to fit)
		// origin defines the point of the texture used as reference for rotation and scaling
		// rotation defines the texture rotation (using origin as rotation point)
		RL_DrawTexturePro( $TEXTURE , $SRC_RECT , $DST_RECT , $ORIGIN , $ROTATION , RL_WHITE );

		RL_DrawLine( $DST_RECT->x , 0 , $DST_RECT->x , $SCREEN_H , RL_GRAY );
		RL_DrawLine( 0 , $DST_RECT->y , $SCREEN_W , $DST_RECT->y , RL_GRAY );

		RL_DrawText( "(c) Ungly sprite by Terminajones.com" , $SCREEN_W - 200 , $SCREEN_H - 20 , 10 , RL_GRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );

RL_CloseWindow();


//EOF
