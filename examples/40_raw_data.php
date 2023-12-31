<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - texture from raw data" );


//$TMP = RL_LoadImage( "./raylib/examples/resources/stickman.png" );
//RL_SaveFileData( "./raylib/examples/resources/stick_man.raw" , $TMP->data , $TMP->width * $TMP->height * 4 );

// Load RAW image data (512x512, 32bit RGBA, no file header)
$STICK_MAN_RAW = RL_LoadImageRaw( "./raylib/examples/resources/stick_man.raw" , 512 , 512 , RL_PIXELFORMAT_UNCOMPRESSED_R8G8B8A8 , 0 );
$STICK_MAN     = RL_LoadTextureFromImage( $STICK_MAN_RAW );
RL_UnloadImage( $STICK_MAN_RAW );


// Generate a checked texture by code
$WIDTH  = 960 ;
$HEIGHT = 480 ;

// Dynamic memory allocation to store pixels data (Color type)
// Note : here we can't use RL_Color_array() because the deletion had
// to be managed by RL_UnloadImage() instead of PHP's garbage collector.
$PIXELS = RL_Color_alloc( $WIDTH * $HEIGHT );

for( $y = 0 ; $y < $HEIGHT ; $y++ )
{
	for( $x = 0 ; $x < $WIDTH ; $x++ )
	{
		if ( ( (int)($x/32) + (int)($y/32) ) % 2 == 0 )
		{
			$PIXELS[ $x + $y * $WIDTH ] = RL_ORANGE ;
		}
		else
		{
			$PIXELS[ $x + $y * $WIDTH ] = RL_GOLD ;
		}
	}
}

// Load pixels data into an image structure and create texture
$CHECKED_IMG = RL_Image([
	'data'    => $PIXELS ,
	'width'   => $WIDTH  ,
	'height'  => $HEIGHT ,
	'format'  => RL_PIXELFORMAT_UNCOMPRESSED_R8G8B8A8 ,
	'mipmaps' => 1 ,
]);

$CHECKED = RL_LoadTextureFromImage( $CHECKED_IMG );
RL_UnloadImage( $CHECKED_IMG );

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawTexture( $CHECKED , (int)($SCREEN_W/2 - $CHECKED->width/2) , (int)($SCREEN_H/2 - $CHECKED->height/2) , RL_Fade( RL_WHITE , 0.5 ) );
		RL_DrawTexture( $STICK_MAN , 350 , -40 - (int)max( 0.0 , sin( RL_GetTime() * 10 ) * 20.0 ) , RL_WHITE );

		RL_DrawText( "CHECKED TEXTURE " , 84 , 85 , 30 , RL_BROWN );
		RL_DrawText( "GENERATED by CODE" , 72 , 148 , 30 , RL_BROWN );
		RL_DrawText( "and RAW IMAGE LOADING" , 46 , 210 , 30 , RL_BROWN );

		RL_DrawText( "(c) Stick man sprite by Terminajones.com" , 310 , $SCREEN_H - 20 , 10 , RL_BROWN );

	RL_EndDrawing();
}

RL_UnloadTexture( $STICK_MAN );
RL_UnloadTexture( $CHECKED   );

RL_CloseWindow();

//EOF
