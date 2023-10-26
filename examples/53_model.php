<?php
//TAB=4


include( './raylib/raylib.ffi.php' );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [models] example - load wavefront model");

$CAMERA = RL_Camera([
	'position' => RL_Vector3( 10.0 , 3.0 , 0.0 ),
	'target'   => RL_Vector3(  0.0 , 3.0 , 0.0 ),
	'up'       => RL_Vector3(  0.0 , 1.0 , 0.0 ),
	'fovy'     => 45.0 ,
	'projection' => RL_CAMERA_PERSPECTIVE ,
]);

$MODEL   = RL_LoadModel( './raylib/examples/resources/elder_zombie_ninja_turtle.obj' );
$TEXTURE = RL_LoadTexture( './raylib/examples/resources/elder_turtle.png' );
RL_SetMaterialTexture( $MODEL->materials[ 0 ] , RL_MATERIAL_MAP_DIFFUSE , $TEXTURE );

$POSITION = RL_Vector3();

RL_SetTargetFPS(60);

while( ! RL_WindowShouldClose() )
{
	RL_UpdateCamera( $CAMERA , RL_CAMERA_ORBITAL );

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			RL_DrawModelEx( $MODEL , $POSITION , RL_Vector3( 1.0 , 0.0 , 0.0  ) , -90.0 , RL_Vector3( 1.0 , 1.0 , 1.0 ) , RL_WHITE );

			RL_DrawGrid( 10 , 1.0 );

		RL_EndMode3D();


		$TEXT = "Elder Zombie Ninja Turtle" ;
		for( $y = -1 ; $y <= 1 ; $y++ )
		{
			for( $x = -1 ; $x <= 1 ; $x++ )
			{
				RL_DrawText( $TEXT , 20 + $x * 3 , $y * 3 + 10 , 50 , RL_BLACK );
			}
		}
		RL_DrawText( $TEXT , 20 , 10 , 50 , RL_GREEN );

	RL_EndDrawing();
}

RL_UnloadModel( $MODEL );
RL_UnloadTexture( $TEXTURE );

RL_CloseWindow();

//EOF
