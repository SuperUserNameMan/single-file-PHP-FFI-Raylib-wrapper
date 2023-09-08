<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - texture loading and drawing" );

// NOTE: Textures MUST be loaded after Window initialization (OpenGL context is required)
$TEXTURE = RL_LoadTexture( "./raylib/examples/resources/logo.png" );

while( ! RL_WindowShouldClose() )
{
	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawTexture( $TEXTURE , $SCREEN_W/2 - $TEXTURE->width/2 , $SCREEN_H/2 - $TEXTURE->height/2 , RL_WHITE );

		RL_DrawText( "this IS a texture!" , 360 , 370 , 10 , RL_GRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );

RL_CloseWindow();

//EOF
