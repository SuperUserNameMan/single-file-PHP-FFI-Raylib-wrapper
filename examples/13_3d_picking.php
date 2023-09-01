<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 3d picking" );

$CAMERA = RL_Camera3D();
$CAMERA->position   = RL_Vector3( 10.0 , 10.0 , 10.0 );
$CAMERA->target     = RL_Vector3(  0.0 ,  0.0 ,  0.0 );
$CAMERA->up         = RL_Vector3(  0.0 ,  1.0 ,  0.0 );
$CAMERA->fovy       = 45.0 ;
$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;

$CUBE_POSITION = RL_Vector3( 0.0 , 1.0 , 0.0 );
$CUBE_SIZE     = RL_Vector3( 2.0 , 2.0 , 2.0 );

$RAY       = RL_Ray();
$COLLISION = RL_RayCollision();

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsCursorHidden() ) RL_UpdateCamera( $CAMERA , RL_CAMERA_FIRST_PERSON );

	if ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_RIGHT ) )
	{
		if ( RL_IsCursorHidden() )
		{
			RL_EnableCursor();
		}
		else
		{
			RL_DisableCursor();
		}
	}

	if ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_LEFT ) )
	{
		if ( ! $COLLISION->hit )
		{
			$RAY = RL_GetMouseRay( RL_GetMousePosition() , $CAMERA );

			// Check collision between ray and box
			$BOUNDING_BOX = RL_BoundingBox
			(
				RL_Vector3Subtract( $CUBE_POSITION , RL_Vector3Scale( $CUBE_SIZE , 0.5 ) ),
				RL_Vector3Add     ( $CUBE_POSITION , RL_Vector3Scale( $CUBE_SIZE , 0.5 ) ),
			);

			$COLLISION = RL_GetRayCollisionBox( $RAY , $BOUNDING_BOX );
		}
		else
		{
			$COLLISION->hit = false;
		}
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			if ( $COLLISION->hit )
			{
				RL_DrawCube     ( $CUBE_POSITION , $CUBE_SIZE->x , $CUBE_SIZE->y , $CUBE_SIZE->z , RL_RED    );
				RL_DrawCubeWires( $CUBE_POSITION , $CUBE_SIZE->x , $CUBE_SIZE->y , $CUBE_SIZE->z , RL_MAROON );

				RL_DrawCubeWires( $CUBE_POSITION , $CUBE_SIZE->x + 0.2 , $CUBE_SIZE->y + 0.2 , $CUBE_SIZE->z + 0.2 , RL_GREEN );
			}
			else
			{
				RL_DrawCube     ( $CUBE_POSITION , $CUBE_SIZE->x , $CUBE_SIZE->y , $CUBE_SIZE->z , RL_GRAY     );
				RL_DrawCubeWires( $CUBE_POSITION , $CUBE_SIZE->x , $CUBE_SIZE->y , $CUBE_SIZE->z , RL_DARKGRAY );
			}

			RL_DrawRay( $RAY , RL_MAROON );
			RL_DrawGrid( 10 , 1.0 );

		RL_EndMode3D();

		RL_DrawText( "Try clicking on the box with your mouse!" , 240 , 10 , 20 , RL_DARKGRAY );

		if ( $COLLISION->hit )
		{
			RL_DrawText( "BOX SELECTED" , ( $SCREEN_W - RL_MeasureText( "BOX SELECTED" , 30 ) ) / 2 , (int)( $SCREEN_H * 0.1 ) , 30 , RL_GREEN );
		}

		RL_DrawText( "Right click mouse to toggle camera controls" , 10 , 430 , 10 , RL_GRAY );

		RL_DrawFPS( 10 , 10 );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
