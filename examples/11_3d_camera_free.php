<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 3d camera free" );

$CAMERA = RL_Camera3D();
$CAMERA->position   = RL_Vector3( 10.0 , 10.0 , 10.0 );
$CAMERA->target     = RL_Vector3(  0.0 ,  0.0 ,  0.0 );
$CAMERA->up         = RL_Vector3(  0.0 ,  1.0 ,  0.0 );
$CAMERA->fovy       = 45.0 ;
$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;

$CUBE_POSITION = RL_Vector3( 0.0 , 0.0 , 0.0 );

RL_DisableCursor();

RL_SetTargetFPS( 60 );

while ( ! RL_WindowShouldClose() )
{
	RL_UpdateCamera( $CAMERA , RL_CAMERA_FREE );

	if ( RL_IsKeyDown( RL_KEY_R ) ) $CAMERA->target = RL_Vector3( 0.0 , 0.0 , 0.0  );

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			RL_DrawCube( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_RED );
			RL_DrawCubeWires( $CUBE_POSITION , 2.0 , 2.0 , 2.0 , RL_MAROON );

			RL_DrawGrid( 10 , 1.0 );

		RL_EndMode3D();

		RL_DrawRectangle( 10 , 10 , 250 , 113 , RL_Fade( RL_SKYBLUE , 0.5 ) );
		RL_DrawRectangleLines( 10 , 10 , 250 , 113 , RL_BLUE );

		RL_DrawText( "Free camera default controls:" , 20 , 20 , 10 , RL_BLACK );
		RL_DrawText( "- Mouse or Arrows to look around"  , 40 , 40 , 10 , RL_DARKGRAY );
		RL_DrawText( "- WASD to move"  , 40 , 60 , 10 , RL_DARKGRAY );
		RL_DrawText( "- Q and E to rotate" , 40 , 80 , 10 , RL_DARKGRAY );
		RL_DrawText( "- R to look at origin" , 40 , 100 , 10 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
