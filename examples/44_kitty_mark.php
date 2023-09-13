<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAX_KITTIES' , 50_000 );

// This is the maximum amount of elements (quads) per batch
// NOTE: This value is hardcoded in [rlgl] module and can be changed at compile time
define( 'MAX_BATCH_ELEMENTS' , RLGL_DEFAULT_BATCH_BUFFER_ELEMENTS );

echo "MAX_BATCH_ELEMENTS : ".MAX_BATCH_ELEMENTS.PHP_EOL;

class Kitty
{
	public object $POSITION ;
	public object $SPEED ;
	public object $COLOR ;

	function __construct()
	{
		$this->POSITION = RL_Vector2();
		$this->SPEED    = RL_Vector2();
		$this->COLOR    = RL_Color();
	}
}

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - kittymark" );

$TEXTURE = RL_LoadTexture( "./raylib/examples/resources/kitty_omega.png");

$KITTIES = []; while( count( $KITTIES ) < MAX_KITTIES ) $KITTIES[] = new Kitty();

$KITTIES_COUNT = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_LEFT ) )
	{
		// Create more bunnies
		for( $i = 0 ; $i < 100 ; $i++ )
		{
			if ( $KITTIES_COUNT < MAX_KITTIES )
			{
				$K = $KITTIES[ $KITTIES_COUNT ];
				$K->POSITION = RL_GetMousePosition() ;
				$K->SPEED->x = RL_GetRandomValue( -250 , 250 ) / 60.0 ;
				$K->SPEED->y = RL_GetRandomValue( -250 , 250 ) / 60.0 ;
				$K->COLOR    = RL_Color( RL_GetRandomValue(  50 , 240 ) , RL_GetRandomValue(  80 , 240 ) , RL_GetRandomValue( 100 , 240 ) , 255 );
				$KITTIES_COUNT++ ;
			}
		}
	}

	for( $i = 0 ; $i < $KITTIES_COUNT ; $i++ )
	{
		$K = $KITTIES[ $i ];
		$K->POSITION->x += $K->SPEED->x ;
		$K->POSITION->y += $K->SPEED->y ;

		if
		(
			( ( $K->POSITION->x + $TEXTURE->width/2 ) > RL_GetScreenWidth() )
			||
			( ( $K->POSITION->x + $TEXTURE->width/2 ) < 0 )
		){
			$K->SPEED->x *= -1 ;
		}

		if
		(
			( ( $K->POSITION->y + $TEXTURE->height/2 ) > RL_GetScreenHeight() )
			||
			( ( $K->POSITION->y + $TEXTURE->height/2 - 40 ) < 0 )
		){
			 $K->SPEED->y *= -1 ;
		}
	}

	RL_BeginDrawing();
		RL_ClearBackground( RL_RAYWHITE );

		for( $i = 0 ; $i < $KITTIES_COUNT ; $i++ )
		{
			// NOTE: When internal batch buffer limit is reached (MAX_BATCH_ELEMENTS),
			// a draw call is launched and buffer starts being filled again;
			// before issuing a draw call, updated vertex data from internal CPU buffer is send to GPU...
			// Process of sending data is costly and it could happen that GPU data has not been completely
			// processed for drawing while new data is tried to be sent (updating current in-use buffers)
			// it could generates a stall and consequently a frame drop, limiting the number of drawn kitties
			RL_DrawTexture( $TEXTURE , (int)$KITTIES[ $i ]->POSITION->x , (int)$KITTIES[ $i ]->POSITION->y , $KITTIES[ $i ]->COLOR );
		}

		RL_DrawRectangle( 0 , 0 , $SCREEN_W , 40 , RL_BLACK );
		RL_DrawText( "kitties: $KITTIES_COUNT" , 120 , 10 , 20 , RL_GREEN );
		RL_DrawText( RL_TextFormat( "batched draw calls: %i", (int)(1 + $KITTIES_COUNT/MAX_BATCH_ELEMENTS) ) , 320 , 10 , 20 , RL_MAROON );

		RL_DrawFPS( 10 , 10 );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );
RL_CloseWindow();


//EOF
