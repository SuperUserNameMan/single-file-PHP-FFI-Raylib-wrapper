<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 3d camera mode" );

$CAMERA = RL_Camera3D();
$CAMERA->position   = RL_Vector3( 0.0 , 10.0 , 10.0 );
$CAMERA->target     = RL_Vector3( 0.0 ,  0.0 ,  0.0 );
$CAMERA->up         = RL_Vector3( 0.0 ,  1.0 ,  0.0 );
$CAMERA->fovy       = 45.0 ;
$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;

$CUBE_POSITION = RL_Vector3();

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			RL_DrawCube( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_RED );
			RL_DrawCubeWires( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_MAROON );

			RL_DrawGrid( 10 , 1.0 );

		RL_EndMode3D();

		RL_DrawText( "Welcome to the third dimension!" , 10 , 40 , 20 , RL_DARKGRAY );

		RL_DrawFPS( 10 , 10 );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
