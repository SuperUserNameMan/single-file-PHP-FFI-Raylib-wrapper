<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 2d camera mouse zoom" );

$ZOOM_INCREMENT = 0.125 ;

$CAMERA = RL_Camera2D();
$CAMERA->zoom = 1.0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_RIGHT ) )
	{
		$DELTA = RL_GetMouseDelta();
		$DELTA = RL_Vector2Scale( $DELTA , -1.0 / $CAMERA->zoom );

		$CAMERA->target = RL_Vector2Add( $CAMERA->target , $DELTA );
	}

	$WHEEL = RL_GetMouseWheelMove();
	if ( $WHEEL != 0 )
	{
		// Get the world point that is under the mouse
		$MOUSE_WORLD_POINT = RL_GetScreenToWorld2D( RL_GetMousePosition() , $CAMERA );

		// Set the offset to where the mouse is
		$CAMERA->offset = RL_GetMousePosition();

		// Set the target to match, so that the camera maps the world space point
		// under the cursor to the screen space point under the cursor at any zoom
		$CAMERA->target = $MOUSE_WORLD_POINT ;

		$CAMERA->zoom += $WHEEL * $ZOOM_INCREMENT ;
		if ( $CAMERA->zoom < $ZOOM_INCREMENT ) $CAMERA->zoom = $ZOOM_INCREMENT ;
	}

	RL_BeginDrawing();
		RL_ClearBackground( RL_BLACK );

		RL_BeginMode2D( $CAMERA );

			// Draw the 3d grid, rotated 90 degrees and centered around 0,0
			// just so we have something in the XY plane
			RL_rlPushMatrix();
				RL_rlTranslatef( 0 , 25*50 , 0 );
				RL_rlRotatef( 90 , 1 , 0 , 0 );
				RL_DrawGrid( 100 , 50 );
			RL_rlPopMatrix();

			// Draw a reference circle
			RL_DrawCircle( 100 , 100 , 50 , RL_YELLOW );

		RL_EndMode2D();

		RL_DrawText( "Mouse right button drag to move, mouse wheel to zoom" , 10 , 10 , 20 , RL_WHITE );

	RL_EndDrawing();
}


RL_CloseWindow();

//EOF
