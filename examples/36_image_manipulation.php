<?php

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - image drawing" );

// NOTE: Textures MUST be loaded after Window initialization (OpenGL context is required)

$CAT = RL_LoadImage( "./raylib/examples/resources/cat.png" ); // Load image in CPU memory (RAM)
RL_ImageCrop( $CAT , RL_Rectangle( 100 , 10 , 280 , 380 ) );  // Crop an image piece
RL_ImageFlipHorizontal( $CAT );                               // Flip cropped image horizontally
RL_ImageResize( $CAT , 150 , 200 );                           // Resize flipped-cropped image

$PARROTS = RL_LoadImage( "./raylib/examples/resources/parrots.png" );     // Load image in CPU memory (RAM)

// Draw one image over the other with a scaling of 1.5f
RL_ImageDraw( $PARROTS , $CAT , RL_Rectangle( 0 , 0 , $CAT->width , $CAT->height ) , RL_Rectangle( 30 , 40 , $CAT->width*1.5 , $CAT->height*1.5 ) , RL_WHITE );
RL_ImageCrop( $PARROTS , RL_Rectangle( 0 , 50 , $PARROTS->width , $PARROTS->height - 100 ) ); // Crop resulting image

// Draw on the image with a few image draw methods
RL_ImageDrawPixel( $PARROTS , 10 , 10 , RL_RAYWHITE );
RL_ImageDrawCircleLines( $PARROTS , 10 , 10 , 5 , RL_RAYWHITE );
RL_ImageDrawRectangle( $PARROTS , 5 , 20 , 10 , 10 , RL_RAYWHITE );

RL_UnloadImage( $CAT );       // Unload image from RAM

// Load custom font for drawing on image
$FONT = RL_LoadFont("./raylib/examples/resources/texture_font_handcrapped.png");

// Draw over image using custom font
RL_ImageDrawTextEx( $PARROTS , $FONT , "PARROTS & CAT" , RL_Vector2( 300 , 230 ) , $FONT->baseSize , -2 , RL_WHITE );

RL_UnloadFont( $FONT );       // Unload custom font (already drawn used on image)

$TEXTURE = RL_LoadTextureFromImage( $PARROTS );      // Image converted to texture, uploaded to GPU memory (VRAM)
RL_UnloadImage( $PARROTS );   // Once image has been converted to texture and uploaded to VRAM, it can be unloaded from RAM

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	RL_BeginDrawing();

	RL_ClearBackground( RL_RAYWHITE );

		RL_DrawTexture( $TEXTURE , $SCREEN_W/2 - $TEXTURE->width/2 , $SCREEN_H/2 - $TEXTURE->height/2 - 40 , RL_WHITE );
		RL_DrawRectangleLines( $SCREEN_W/2 - $TEXTURE->width/2 , $SCREEN_H/2 - $TEXTURE->height/2 - 40 , $TEXTURE->width , $TEXTURE->height , RL_DARKGRAY );

		RL_DrawText( "We are drawing only one texture from various images composed!" , 60 , 350 , 20 , RL_DARKGRAY );
		RL_DrawText( "Source images have been cropped, scaled, flipped and copied together." , 30 , 380 , 20 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );

RL_CloseWindow();

//EOF
