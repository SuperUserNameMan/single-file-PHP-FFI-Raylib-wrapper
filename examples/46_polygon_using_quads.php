<?php
//TAB=4

include('./raylib/raylib.ffi.php');


// Draw a textured polygon, as a triangles fan made of quads
// NOTE: Polygon center must have straight line path to all points
// without crossing perimeter, points must be in anticlockwise order
function DrawTexturePoly( object $texture , object $center , array $points , array $texcoords , object $tint ) : void
{
	// XXX The original example claims that only quads supports texturing without giving extra information.
	// XXX So, to simulate triangles fan using quads, we must repeat one vertex twice.
	// XXX It is however possible to texture triangles if rlSetTexture() is defined after rlBegin().
	// XXX See example/46_polygon_using_triangles.php

	RL_rlSetTexture( $texture->id );

	RL_rlBegin( RLGL_QUADS );

		RL_rlColor4ub( $tint->r , $tint->g , $tint->b , $tint->a );

		$pointCount = min( count( $points ) , count( $texcoords ) ); // <= should better warn user instead

		for( $i = 0 ; $i < $pointCount - 1 ; $i++ )
		{
			RL_rlTexCoord2f( 0.5 , 0.5 );
			RL_rlVertex2f( $center->x , $center->y );

			RL_rlTexCoord2f( 0.5 , 0.5 );
			RL_rlVertex2f( $center->x , $center->y );


			RL_rlTexCoord2f( $texcoords[ $i ]->x , $texcoords[ $i ]->y );
			RL_rlVertex2f( $points[ $i ]->x + $center->x , $points[ $i ]->y + $center->y );

			RL_rlTexCoord2f( $texcoords[ $i + 1 ]->x , $texcoords[ $i + 1 ]->y );
			RL_rlVertex2f( $points[ $i + 1 ]->x + $center->x , $points[ $i + 1 ]->y + $center->y );
		}
		RL_rlEnd();

	RL_rlSetTexture( 0 );
}

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - textured polygon" );

$TEXCOORDS = [
	RL_Vector2( 0.5   , 1.0   ) ,
	RL_Vector2( 0.8   , 0.75   ) ,
	RL_Vector2( 0.95   , 0.5   ) ,
	RL_Vector2( 1.0   , 0.25  ) ,
	RL_Vector2( 0.9   , 0.05  ) ,
	RL_Vector2( 0.75  , 0.0   ) ,
	RL_Vector2( 0.6   , 0.05  ) ,
	RL_Vector2( 0.5   , 0.15   ) ,
	RL_Vector2( 0.4   , 0.05  ) ,
	RL_Vector2( 0.25  , 0.0   ) ,
	RL_Vector2( 0.1   , 0.05  ) ,
	RL_Vector2( 0.0   , 0.25  ) ,
	RL_Vector2( 0.05   , 0.5   ) ,
	RL_Vector2( 0.2   , 0.75   ) ,
	RL_Vector2( 0.5   , 1.0   ) ,
];

// Define the base poly vertices from the UV's
// NOTE: They can be specified in any other way
$POINTS = [];
foreach( $TEXCOORDS as $TC )
{
	$POINTS[] = RL_Vector2
	(
		( $TC->x - 0.5 ) * 300.0 ,
		( $TC->y - 0.5 ) * 250.0 ,
	);
}

// Define the vertices drawing position
// NOTE: Initially same as points but updated every frame
$POSITIONS = [];
foreach( $POINTS as $POINT ) { $POSITIONS[] = clone $POINT ; }

// Load texture to be mapped to poly
$TEXTURE = RL_LoadTexture( './raylib/examples/resources/parrots.png' );

$ANGLE = 0.0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$WAVE = sin( RL_GetTime() * 10 );

	$ANGLE = 20 * $WAVE ;

	for( $i = 0 ; $i < count( $POINTS ) ; $i++ )
	{
		$POSITIONS[ $i ] = clone RL_Vector2Rotate( $POINTS[ $i ] , $ANGLE*RL_DEG2RAD ); // not very efficient way to rotate a polygon
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( "textured polygon" , 20 , 20 , 20 , RL_DARKGRAY );

		RL_rlPushMatrix();

			RL_rlScalef
			(
				1.0 + $WAVE * 0.05 ,
				1.0 + $WAVE * 0.1 ,
				1.0 ,
			);

			DrawTexturePoly
			(
				$TEXTURE ,
				RL_Vector2( RL_GetScreenWidth()/2.0 , RL_GetScreenHeight()/2.0 ) ,
				$POSITIONS ,
				$TEXCOORDS ,
				RL_Color
				(
					200 + 50 * $WAVE ,
					200 - 50 * $WAVE ,
					200 - 50 * $WAVE ,
					255
				),
			);

		RL_rlPopMatrix();

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE );

RL_CloseWindow();

//EOF
