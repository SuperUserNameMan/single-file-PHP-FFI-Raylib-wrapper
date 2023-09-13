<?php
//TAB=4

include('./raylib/raylib.ffi.php');

enum IMAGE_PROCESS : string
{
	case NONE = 'NO PROCESSING' ;
	case COLOR_GRAYSCALE = 'COLOR GRAYSCALE' ;
	case COLOR_TINT = 'COLOR TINT' ;
	case COLOR_INVERT = 'COLOR INVERT' ;
	case COLOR_CONTRAST = 'COLOR CONTRAST' ;
	case COLOR_BRIGHTNESS = 'COLOR BRIGHTNESS' ;
	case GAUSSIAN_BLUR = 'GAUSSIAN BLUR' ;
	case FLIP_VERTICAL = 'FLIP VERTICAL' ;
	case FLIP_HORIZONTAL = 'FLIP HORIZONTAL' ;

	static function count() : int { return count( self::cases() ); }
}

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - image processing" );

$IMAGE_ORIGINAL = RL_LoadImage( "./raylib/examples/resources/parrots.png" );
RL_ImageFormat( $IMAGE_ORIGINAL , RL_PIXELFORMAT_UNCOMPRESSED_R8G8B8A8 );
$TEXTURE = RL_LoadTextureFromImage( $IMAGE_ORIGINAL );

$IMAGE_COPY = RL_ImageCopy( $IMAGE_ORIGINAL );

$CURRENT_PROCESS = IMAGE_PROCESS::NONE ;
$TEXTURE_RELOAD  = false ;

$TOGGLE_RECTANGLES = [];

$MOUSE_HOVER_REC = -1 ;

for( $i = 0 ; $i < IMAGE_PROCESS::count() ; $i++ )
{
	$TOGGLE_RECTANGLES[ $i ] = RL_Rectangle( 40.0 ,  50 + 32*$i , 150.0 , 30.0  );
}


RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	for( $i = 0 ; $i < IMAGE_PROCESS::count() ; $i++ )
	{
		if ( RL_CheckCollisionPointRec( RL_GetMousePosition() , $TOGGLE_RECTANGLES[ $i ] ) )
		{
			$MOUSE_HOVER_REC = $i ;

			if ( RL_IsMouseButtonReleased( RL_MOUSE_BUTTON_LEFT ) )
			{
				$CURRENT_PROCESS = $i ;
				$TEXTURE_RELOAD  = true ;
			}
			break;
		}
		else $MOUSE_HOVER_REC = -1 ;
	}

	// Keyboard toggle group logic
	if ( RL_IsKeyPressed( RL_KEY_DOWN ) )
	{
		$CURRENT_PROCESS++ ;

		if ( $CURRENT_PROCESS > ( IMAGE_PROCESS::count() - 1 ) )
		{
			$CURRENT_PROCESS = 0 ;
		}

		$TEXTURE_RELOAD = true ;
	}
	else
	if ( RL_IsKeyPressed( RL_KEY_UP ) )
	{
		$CURRENT_PROCESS-- ;
		if ( $CURRENT_PROCESS < 0 )
		{
			$CURRENT_PROCESS = IMAGE_PROCESS::count() - 1 ;
		}
		$TEXTURE_RELOAD = true ;
	}

	// Reload texture when required
	if ( $TEXTURE_RELOAD )
	{
		RL_UnloadImage( $IMAGE_COPY );
		$IMAGE_COPY = RL_ImageCopy( $IMAGE_ORIGINAL );

		switch( IMAGE_PROCESS::cases()[ $CURRENT_PROCESS ] )
		{
			case IMAGE_PROCESS::COLOR_GRAYSCALE : RL_ImageColorGrayscale ( $IMAGE_COPY            ); break;
			case IMAGE_PROCESS::COLOR_TINT      : RL_ImageColorTint      ( $IMAGE_COPY , RL_GREEN ); break;
			case IMAGE_PROCESS::COLOR_INVERT    : RL_ImageColorInvert    ( $IMAGE_COPY            ); break;
			case IMAGE_PROCESS::COLOR_CONTRAST  : RL_ImageColorContrast  ( $IMAGE_COPY , -40      ); break;
			case IMAGE_PROCESS::COLOR_BRIGHTNESS: RL_ImageColorBrightness( $IMAGE_COPY , -80      ); break;
			case IMAGE_PROCESS::GAUSSIAN_BLUR   : RL_ImageBlurGaussian   ( $IMAGE_COPY ,  10      ); break;
			case IMAGE_PROCESS::FLIP_VERTICAL   : RL_ImageFlipVertical   ( $IMAGE_COPY            ); break;
			case IMAGE_PROCESS::FLIP_HORIZONTAL : RL_ImageFlipHorizontal ( $IMAGE_COPY            ); break;
			default: break;
		}

		$PIXELS = RL_LoadImageColors( $IMAGE_COPY );  // Load pixel data from image (RGBA 32bit)
		RL_UpdateTexture( $TEXTURE , $PIXELS );       // Update texture with new image data
		RL_UnloadImageColors( $PIXELS );              // Unload pixels data from RAM

		$TEXTURE_RELOAD = false ;
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( "IMAGE PROCESSING:" , 40 , 30 , 10 , RL_DARKGRAY );

		for( $i = 0 ; $i < IMAGE_PROCESS::count() ; $i++ )
		{
			RL_DrawRectangleRec( $TOGGLE_RECTANGLES[ $i ] , ( ( $i == $CURRENT_PROCESS ) || ( $i == $MOUSE_HOVER_REC ) ) ? RL_SKYBLUE : RL_LIGHTGRAY );
			RL_DrawRectangleLines
			(
				$TOGGLE_RECTANGLES[ $i ]->x ,
				$TOGGLE_RECTANGLES[ $i ]->y ,
				$TOGGLE_RECTANGLES[ $i ]->width ,
				$TOGGLE_RECTANGLES[ $i ]->height ,
				( ( $i == $CURRENT_PROCESS ) || ( $i == $MOUSE_HOVER_REC ) ) ? RL_BLUE : RL_GRAY
			);

			$LABEL = IMAGE_PROCESS::cases()[ $i ]->value ;
			RL_DrawText
			(
				$LABEL ,
				$TOGGLE_RECTANGLES[ $i ]->x + (int)( $TOGGLE_RECTANGLES[ $i ]->width/2 - RL_MeasureText( $LABEL , 10 ) /2 ) ,
				$TOGGLE_RECTANGLES[ $i ]->y + 11 ,
				10 ,
				( ( $i == $CURRENT_PROCESS ) || ( $i == $MOUSE_HOVER_REC ) ) ? RL_DARKBLUE : RL_DARKGRAY
			);
		}

		RL_DrawTexture( $TEXTURE , $SCREEN_W - $TEXTURE->width - 60 , (int)( $SCREEN_H/2 - $TEXTURE->height/2 ) , RL_WHITE );
		RL_DrawRectangleLines( $SCREEN_W - $TEXTURE->width - 60 , (int)( $SCREEN_H/2 - $TEXTURE->height/2 ) , $TEXTURE->width , $TEXTURE->height , RL_BLACK );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );
RL_UnloadImage( $IMAGE_ORIGINAL );
RL_UnloadImage( $IMAGE_COPY );

RL_CloseWindow();

//EOF
