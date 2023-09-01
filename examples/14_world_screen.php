<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - core world screen" );

$CAMERA = RL_Camera3D();
$CAMERA->position   = RL_Vector3( 10.0 , 10.0 , 10.0 );
$CAMERA->target     = RL_Vector3(  0.0 ,  0.0 ,  0.0 );
$CAMERA->up         = RL_Vector3(  0.0 ,  1.0 ,  0.0 );
$CAMERA->fovy       = 45.0 ;
$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;

$CUBE_POSITION        = RL_Vector3( 0.0 , 0.0 , 0.0 );
$CUBE_SCREEN_POSITION = RL_Vector2( 0.0 , 0.0 );

RL_DisableCursor();

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	RL_UpdateCamera( $CAMERA , RL_CAMERA_THIRD_PERSON );

	// Calculate cube screen space position (with a little offset to be in top)
	$CUBE_SCREEN_POSITION = RL_GetWorldToScreen( RL_Vector3( $CUBE_POSITION->x , $CUBE_POSITION->y + 2.5 , $CUBE_POSITION->z ) , $CAMERA );

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			RL_DrawCube     ( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_RED    );
			RL_DrawCubeWires( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_MAROON );

			RL_DrawGrid( 10 , 1.0 );

		RL_EndMode3D();

		RL_DrawText
		(
			"Enemy: 100 / 100" ,
			(int)$CUBE_SCREEN_POSITION->x - RL_MeasureText ("Enemy: 100/100" , 20 ) / 2 ,
			(int)$CUBE_SCREEN_POSITION->y ,
			20 , RL_BLACK
		);

		RL_DrawText
		(
			RL_TextFormat
			(
				"Cube position in screen space coordinates: [%i, %i]" ,
				(int)$CUBE_SCREEN_POSITION->x ,
				(int)$CUBE_SCREEN_POSITION->y
			) ,
			10 , 10 , 20 , RL_LIME
		);

		RL_DrawText( "Text 2d should be always on top of the cube" , 10 , 40 , 20 , RL_GRAY );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
