<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - procedural images generation" );

$IMAGES = [
	'VERTICAL GRADIENT'   => RL_GenImageGradientV( $SCREEN_W , $SCREEN_H , RL_BLUE , RL_YELLOW) ,
	'HORIZONTAL GRADIENT' => RL_GenImageGradientH( $SCREEN_W , $SCREEN_H , RL_YELLOW , RL_BLUE ) ,
//	'DIAGONAL GRADIENT'   => RL_GenImageGradientLinear( $SCREEN_W , $SCREEN_H , 45 , RL_YELLOW , RL_BLUE ) , // only available in Raylib 4.6
	'RADIAL GRADIENT'     => RL_GenImageGradientRadial( $SCREEN_W , $SCREEN_H , 0.0 , RL_WHITE , RL_BLACK ) ,
//	'SQUARE GRADIENT'     => RL_GenImageGradientSquare( $SCREEN_W , $SCREEN_H , 0.0 , RL_WHITE , RL_BLACK ) , // only available in Raylib 4.6
	'CHECKED'             => RL_GenImageChecked( $SCREEN_W , $SCREEN_H , 32 , 32 , RL_YELLOW , RL_BLUE ) ,
	'WHITE NOISE'         => RL_GenImageWhiteNoise( $SCREEN_W , $SCREEN_H , 0.5 ) ,
	'PERLIN NOISE'        => RL_GenImagePerlinNoise( $SCREEN_W , $SCREEN_H , 50 , 50 , 4.0 ) ,
	'CELLULAR'            => RL_GenImageCellular( $SCREEN_W , $SCREEN_H , 32 ) ,
];

$TEXTURES = [];

foreach( $IMAGES as $NAME => $IMAGE )
{
	$TEXTURES[] = (object)[ 'texture' => RL_LoadTextureFromImage( $IMAGE ) , 'name' => $NAME ];
	RL_UnloadImage( $IMAGE );
}

$CURRENT_TEXTURE = 0 ;


RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose())
{
	if ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_LEFT ) || RL_IsKeyPressed( RL_KEY_RIGHT ) )
	{
		$CURRENT_TEXTURE = ( $CURRENT_TEXTURE + 1 ) % count( $TEXTURES ) ; // Cycle between the textures
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawTexture( $TEXTURES[ $CURRENT_TEXTURE ]->texture , 0 , 0 , RL_WHITE );

		RL_DrawRectangle     ( 30 , 400 , 325 , 30 , RL_Fade( RL_SKYBLUE , 0.75 ) );
		RL_DrawRectangleLines( 30 , 400 , 325 , 30 , RL_Fade( RL_WHITE   , 0.5 ) );

		RL_DrawText( "MOUSE LEFT BUTTON to CYCLE PROCEDURAL TEXTURES" , 40 , 410 , 10 , RL_WHITE );

		$FONT_SIZE = 30 ;
		$TEXT = $TEXTURES[ $CURRENT_TEXTURE ]->name ;
		$TEXT_X = 600 ;
		$TEXT_Y =  10 ;
		$TEXT_W = RL_MeasureText( $TEXT , $FONT_SIZE );

		for( $Y_OFFSET = -1 ; $Y_OFFSET <= 1 ; $Y_OFFSET++ )
		for( $X_OFFSET = -1 ; $X_OFFSET <= 1 ; $X_OFFSET++ )
		{
			RL_DrawText( $TEXT , $TEXT_X - $TEXT_W / 2 + $X_OFFSET*2 , $TEXT_Y + $Y_OFFSET*2 , $FONT_SIZE , RL_BLACK );
		}

		RL_DrawText( $TEXTURES[ $CURRENT_TEXTURE ]->name , $TEXT_X - $TEXT_W / 2 , $TEXT_Y , $FONT_SIZE , RL_WHITE );

	RL_EndDrawing();
}

foreach( $TEXTURES as $TEXTURE ) RL_UnloadTexture( $TEXTURE->texture );

RL_CloseWindow();

//EOF
