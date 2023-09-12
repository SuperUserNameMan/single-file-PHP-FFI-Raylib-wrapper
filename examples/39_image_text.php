<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [texture] example - image text drawing" );

$PARROTS = RL_LoadImage( "./raylib/examples/resources/parrots.png" );

$FONT = RL_LoadFontEx( "./raylib/examples/resources/Lockergnome.otf" , 64 , NULL , 0);

for( $y = -1 ; $y <= 1 ; $y++ ) for( $x = -1 ; $x <= 1 ; $x++ )
{
	RL_ImageDrawTextEx( $PARROTS , $FONT , "[Parrots font drawing]" , RL_Vector2( 20.0 + $x*2 , 20.0 + $y*2 ) , $FONT->baseSize * 0.6 , 0.0 , RL_WHITE );
}
RL_ImageDrawTextEx( $PARROTS , $FONT , "[Parrots font drawing]" , RL_Vector2( 20.0 , 20.0 ) , $FONT->baseSize * 0.6 , 0.0 , RL_RED );

$TEXTURE = RL_LoadTextureFromImage( $PARROTS );
RL_UnloadImage( $PARROTS );

$POSITION = RL_Vector2( $SCREEN_W/2 - $TEXTURE->width/2 , $SCREEN_H/2 - $TEXTURE->height/2 - 20 );

$SHOW_FONT = false ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$SHOW_FONT = RL_IsKeyDown( RL_KEY_SPACE ) ;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		if ( ! $SHOW_FONT )
		{
			RL_DrawTextureV( $TEXTURE , $POSITION , RL_WHITE );

			for( $y = -1 ; $y <= 1 ; $y++ ) for( $x = -1 ; $x <= 1 ; $x++ )
			{
				RL_DrawTextEx
				(
					$FONT ,
					"[Parrots font drawing]" ,
					RL_Vector2( 30 + $x*2 , $POSITION->y + $y * 2 + 20 + 280 ) ,
					$FONT->baseSize ,
					0.0 ,
					RL_RED
				);
			}

			RL_DrawTextEx
			(
				$FONT ,
				"[Parrots font drawing]" ,
				RL_Vector2( 30 , $POSITION->y + 20 + 280 ) ,
				$FONT->baseSize ,
				0.0 ,
				RL_WHITE
			);
		}
		else
		{
			RL_DrawTexture( $FONT->texture , $SCREEN_W/2 - $FONT->texture->width/2 , 50 , RL_BLACK );
		}

		RL_DrawText( "PRESS SPACE to SHOW FONT ATLAS USED" , 290 , 420 , 10 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );

RL_UnloadFont( $FONT );

RL_CloseWindow();

//EOF
