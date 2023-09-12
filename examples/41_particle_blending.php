<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAX_PARTICLES' , 200 );

class Particle
{
	public object $POSITION ;
	public object $COLOR ;
	public float  $ALPHA ;
	public float  $SIZE ;
	public float  $ROTATION ;
	public bool   $ACTIVE ;
}

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - particles blending" );

$PARTICLES = [];

for( $i = 0 ; $i < MAX_PARTICLES ; $i++ )
{
	$P = new Particle();

	$P->POSITION = RL_Vector2( 0 , 0 );
	$P->COLOR    = RL_Color( RL_GetRandomValue( 0 , 255 ) , RL_GetRandomValue( 0 , 255 ) , RL_GetRandomValue( 0 , 255 ) , 255 );
	$P->ALPHA    = 1.0 ;
	$P->SIZE     = (float)RL_GetRandomValue( 1 , 30 ) / 20.0 ;
	$P->ROTATION = (float)RL_GetRandomValue( 0 , 360 );
	$P->ACTIVE   = false ;

	$PARTICLES[ $i ] = $P ;
}

$GRAVITY = 3.0 ;

$SMOKE = RL_LoadTexture( "./raylib/examples/resources/fart.png" );

$BLENDING = RL_BLEND_ALPHA;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	// Activate one particle every frame and Update active particles
	// NOTE: Particles initial position should be mouse position when activated
	// NOTE: Particles fall down with gravity and rotation... and disappear after 2 seconds (alpha = 0)
	// NOTE: When a particle disappears, active = false and it can be reused.
	for( $i = 0 ; $i < MAX_PARTICLES ; $i++ )
	{
		if ( ! $PARTICLES[ $i ]->ACTIVE )
		{
			$PARTICLES[ $i ]->ACTIVE = true ;
			$PARTICLES[ $i ]->ALPHA  = 1.0 ;
			$PARTICLES[ $i ]->POSITION = RL_GetMousePosition();
			break;
		}
	}

	for( $i = 0 ; $i < MAX_PARTICLES ; $i++ )
	{
		if ( $PARTICLES[ $i ]->ACTIVE )
		{
			$PARTICLES[ $i ]->POSITION->y += $GRAVITY/2 ;
			$PARTICLES[ $i ]->ALPHA       -= 0.005 ;

			if ( $PARTICLES[ $i ]->ALPHA <= 0.0 ) $PARTICLES[ $i ]->ACTIVE = false ;

			$PARTICLES[ $i ]->ROTATION += 2.0 ;
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_SPACE ) )
	{
		if ( $BLENDING == RL_BLEND_ALPHA )
		{
			$BLENDING = RL_BLEND_ADDITIVE ;
		}
		else
		{
			$BLENDING = RL_BLEND_ALPHA ;
		}
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_DARKGRAY );

		RL_BeginBlendMode( $BLENDING );

			for( $i = 0 ; $i < MAX_PARTICLES ; $i++ )
			{
				if ( $PARTICLES[ $i ]->ACTIVE )
				{
					RL_DrawTexturePro
					(
						$SMOKE ,
						RL_Rectangle( 0.0 , 0.0 , $SMOKE->width , $SMOKE->height ) ,
						RL_Rectangle
						(
							$PARTICLES[ $i ]->POSITION->x ,
							$PARTICLES[ $i ]->POSITION->y ,
							$SMOKE->width  * $PARTICLES[ $i ]->SIZE ,
							$SMOKE->height * $PARTICLES[ $i ]->SIZE ,
						),
						RL_Vector2
						(
							$SMOKE->width  * $PARTICLES[ $i ]->SIZE / 2.0 ,
							$SMOKE->height * $PARTICLES[ $i ]->SIZE / 2.0 ,
						),
						$PARTICLES[ $i ]->ROTATION ,
						RL_Fade( $PARTICLES[ $i ]->COLOR , $PARTICLES[ $i ]->ALPHA )
					);
				}
			}

		RL_EndBlendMode();

		RL_DrawText( "PRESS SPACE to CHANGE BLENDING MODE" , 180 , 20 , 20 , RL_BLACK );

		if ( $BLENDING == RL_BLEND_ALPHA )
		{
			RL_DrawText( "ALPHA BLENDING" , 290 , $SCREEN_H - 40 , 20 , RL_BLACK );
		}
		else
		{
			RL_DrawText( "ADDITIVE BLENDING" , 280 , $SCREEN_H - 40 , 20 , RL_RAYWHITE );
		}
	RL_EndDrawing();
}

RL_UnloadTexture( $SMOKE );

RL_CloseWindow();
//EOF
