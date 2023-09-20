<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAX_FRAME_DELAY' , 20 );
define( 'MIN_FRAME_DELAY' ,  1 );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - gif playing" );

$ANIME_FRAMES = 0;

// Load all GIF animation frames into a single Image
// NOTE: GIF data is always loaded as RGBA (32bit) by default
// NOTE: Frames are just appended one after another in image.data memory
$IMG_UGLY_ANIM = RL_LoadImageAnim( "./raylib/examples/resources/ugly.gif" , $ANIME_FRAMES );

// Load texture from image
// NOTE: We will update this texture when required with next frame data
// WARNING: It's not recommended to use this technique for sprites animation,
// use spritesheets instead, like illustrated in textures_sprite_anim example
$TEX_ULGY_ANIM = RL_LoadTextureFromImage( $IMG_UGLY_ANIM );

$NEXT_FRAME_DATA_OFFSET = 0 ;   // Current byte offset to next frame in image.data

$CURRENT_ANIM_FRAME = 0 ;       // Current animation frame to load and draw

$FRAME_DELAY         = 8 ;
$FRAME_DELAY_COUNTER = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$FRAME_DELAY_COUNTER++ ;
	if ( $FRAME_DELAY_COUNTER >= $FRAME_DELAY )
	{
		$CURRENT_ANIM_FRAME++ ;
		if ( $CURRENT_ANIM_FRAME >= $ANIME_FRAMES ) $CURRENT_ANIM_FRAME = 0 ;

		// Get memory offset position for next frame data in image.data
		$NEXT_FRAME_DATA_OFFSET = $IMG_UGLY_ANIM->width * $IMG_UGLY_ANIM->height * 4 * $CURRENT_ANIM_FRAME ;

		// Update GPU texture data with next frame image data
		// WARNING: Data size (frame size) and pixel format must match already created texture
		RL_UpdateTexture( $TEX_ULGY_ANIM , FFI::addr( $IMG_UGLY_ANIM->data[ $NEXT_FRAME_DATA_OFFSET ] ) );

		$FRAME_DELAY_COUNTER = 0 ;
	}

	// Control frames delay
	if ( RL_IsKeyPressed( RL_KEY_RIGHT ) ) $FRAME_DELAY++ ;
	else
	if ( RL_IsKeyPressed( RL_KEY_LEFT  ) ) $FRAME_DELAY-- ;

	if ( $FRAME_DELAY > MAX_FRAME_DELAY ) $FRAME_DELAY = MAX_FRAME_DELAY ;
	else
	if ( $FRAME_DELAY < MIN_FRAME_DELAY ) $FRAME_DELAY = MIN_FRAME_DELAY ;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( "TOTAL GIF FRAMES: $ANIME_FRAMES"                          , 50 , 30 , 20 , RL_LIGHTGRAY );
		RL_DrawText( "CURRENT FRAME: $CURRENT_ANIM_FRAME"                       , 50 , 60 , 20 , RL_GRAY      );
		RL_DrawText( "CURRENT FRAME IMAGE.DATA OFFSET: $NEXT_FRAME_DATA_OFFSET" , 50 , 90 , 20 , RL_GRAY      );

		RL_DrawText( "FRAMES DELAY: " , 100 , 305 , 10 , RL_DARKGRAY );
		RL_DrawText( "$FRAME_DELAY frames" , 620 , 305 , 10 , RL_DARKGRAY );
		RL_DrawText( "PRESS RIGHT/LEFT KEYS to CHANGE SPEED!" , 290 , 350 , 10 , RL_DARKGRAY );

		for( $i = 0 ; $i < MAX_FRAME_DELAY ; $i++ )
		{
			if ( $i < $FRAME_DELAY ) RL_DrawRectangle( 190 + 21 * $i , 300 , 20 , 20 , RL_RED );
			RL_DrawRectangleLines( 190 + 21*$i , 300 , 20 , 20 , RL_MAROON );
		}

		RL_DrawTexture( $TEX_ULGY_ANIM , RL_GetScreenWidth()/2 - $TEX_ULGY_ANIM->width/2 , 140 , RL_WHITE );

		RL_DrawText("(c) Ugly sprite by Terminajones.com" , $SCREEN_W - 200 , $SCREEN_H - 20 , 10 , RL_GRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEX_ULGY_ANIM );
RL_UnloadImage( $IMG_UGLY_ANIM );

RL_CloseWindow();

//EOF
