<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAX_COLUMNS' , 20 );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - 3d camera first person" );

$CAMERA = RL_Camera3D();
$CAMERA->position  = RL_Vector3( 0.0 , 2.0 , 4.0 );
$CAMERA->target     = RL_Vector3( 0.0 , 2.0 , 0.0 );
$CAMERA->up         = RL_Vector3( 0.0 , 1.0 , 0.0 );
$CAMERA->fovy       = 60.0 ;
$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;

$CAMERA_MODE = RL_CAMERA_FIRST_PERSON ;

$HEIGHTS   = [] ;
$POSITIONS = [] ;
$COLORS    = [] ;

for( $i = 0 ; $i < MAX_COLUMNS ; $i++ )
{
	$HEIGHTS  [ $i ] = (float)RL_GetRandomValue( 1 , 12 );
	$POSITIONS[ $i ] = RL_Vector3( RL_GetRandomValue( -15 ,  15 ) , $HEIGHTS[ $i ] / 2.0 , RL_GetRandomValue( -15 , 15 ) );
	$COLORS   [ $i ] = RL_Color  ( RL_GetRandomValue(  20 , 255 ) , RL_GetRandomValue( 10 , 55 ) , 30 , 255 );
}

RL_DisableCursor();

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsKeyPressed( RL_KEY_ONE ) )
	{
		$CAMERA_MODE = RL_CAMERA_FREE ;
		$CAMERA->up  = RL_Vector3( 0.0 , 1.0 , 0.0 );
	}

	if ( RL_IsKeyPressed( RL_KEY_TWO ) )
	{
		$CAMERA_MODE = RL_CAMERA_FIRST_PERSON ;
		$CAMERA->up  = RL_Vector3( 0.0 , 1.0 , 0.0  );
	}

	if ( RL_IsKeyPressed( RL_KEY_THREE ) )
	{
		$CAMERA_MODE = RL_CAMERA_THIRD_PERSON ;
		$CAMERA->up  = RL_Vector3( 0.0 , 1.0 , 0.0 );
	}

	if ( RL_IsKeyPressed( RL_KEY_FOUR ) )
	{
		$CAMERA_MODE = RL_CAMERA_ORBITAL ;
		$CAMERA->up  = RL_Vector3( 0.0 , 1.0 , 0.0 );
	}

	if ( RL_IsKeyPressed( RL_KEY_P ) )
	{
		if ( $CAMERA->projection == RL_CAMERA_PERSPECTIVE )
		{
			// Create isometric view
			$CAMERA_MODE = RL_CAMERA_THIRD_PERSON ;
			// Note: The target distance is related to the render distance in the orthographic projection
			$CAMERA->position   = RL_Vector3( 0.0 , 2.0 , -100.0 );
			$CAMERA->target     = RL_Vector3( 0.0 , 2.0 ,    0.0 );
			$CAMERA->up         = RL_Vector3( 0.0 , 1.0 ,    0.0 );
			$CAMERA->projection = RL_CAMERA_ORTHOGRAPHIC ;
			$CAMERA->fovy       = 20.0 ;
			RL_CameraYaw(   $CAMERA , -135 * RL_DEG2RAD , true );
			RL_CameraPitch( $CAMERA ,  -45 * RL_DEG2RAD , true , true , false );
		}
		else
		if ( $CAMERA->projection == RL_CAMERA_ORTHOGRAPHIC )
		{
			// Reset to default view
			$CAMERA_MODE = RL_CAMERA_THIRD_PERSON;
			$CAMERA->position   = RL_Vector3( 0.0 , 2.0 , 10.0 );
			$CAMERA->target     = RL_Vector3( 0.0 , 2.0 ,  0.0 );
			$CAMERA->up         = RL_Vector3( 0.0 , 1.0 ,  0.0 );
			$CAMERA->projection = RL_CAMERA_PERSPECTIVE ;
			$CAMERA->fovy       = 60.0 ;
		}
	}

	RL_UpdateCamera( $CAMERA , $CAMERA_MODE );

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_BeginMode3D( $CAMERA );

			RL_DrawPlane( RL_Vector3(   0.0 , 0.0 ,  0.0 ) , RL_Vector2( 32.0 , 32.0 ) , RL_LIGHTGRAY ); // Draw ground
			RL_DrawCube ( RL_Vector3( -16.0 , 2.5 ,  0.0 ) ,  1.0 , 5.0 , 32.0 , RL_BLUE );              // Draw a blue wall
			RL_DrawCube ( RL_Vector3(  16.0 , 2.5 ,  0.0 ) ,  1.0 , 5.0 , 32.0 , RL_LIME );              // Draw a green wall
			RL_DrawCube ( RL_Vector3(   0.0 , 2.5 , 16.0 ) , 32.0 , 5.0 ,  1.0 , RL_GOLD );              // Draw a yellow wall

			for ( $i = 0 ; $i < MAX_COLUMNS ; $i++ )
			{
				RL_DrawCube( $POSITIONS[ $i ] , 2.0 , $HEIGHTS[ $i ] , 2.0 , $COLORS[ $i ] );
				RL_DrawCubeWires( $POSITIONS[ $i ] , 2.0 , $HEIGHTS[ $i ] , 2.0 , RL_MAROON );
			}

			// Draw player cube
			if ( $CAMERA_MODE == RL_CAMERA_THIRD_PERSON )
			{
				RL_DrawCube( $CAMERA->target , 0.5 , 0.5 , 0.5 , RL_PURPLE );
				RL_DrawCubeWires( $CAMERA->target , 0.5 , 0.5 , 0.5 , RL_DARKPURPLE );
			}

		RL_EndMode3D();

		RL_DrawRectangle( 5 , 5 , 330 , 100 , RL_Fade( RL_SKYBLUE , 0.5 ) );
		RL_DrawRectangleLines( 5 , 5 , 330 , 100 , RL_BLUE );

		RL_DrawText( "Camera controls:" , 15 , 15 , 10 , RL_BLACK );
		RL_DrawText( "- Move keys: W, A, S, D, Space, Left-Ctrl" , 15 , 30 , 10 , RL_BLACK );
		RL_DrawText( "- Look around: arrow keys or mouse" , 15 , 45 , 10 , RL_BLACK );
		RL_DrawText( "- Camera mode keys: 1, 2, 3, 4" , 15 , 60 , 10 , RL_BLACK );
		RL_DrawText( "- Zoom keys: num-plus, num-minus or mouse scroll" , 15 , 75 , 10 , RL_BLACK );
		RL_DrawText( "- Camera projection key: P" , 15 , 90 , 10 , RL_BLACK );
		RL_DrawRectangle( 600 , 5 , 195 , 100 , RL_Fade( RL_SKYBLUE , 0.5 ) );
		RL_DrawRectangleLines( 600 , 5 , 195 , 100 , RL_BLUE );

		RL_DrawText( "Camera status:" , 610 , 15 , 10 , RL_BLACK );

		$CAMERA_MODE_NAME = match( $CAMERA_MODE )
		{
			RL_CAMERA_FREE         => "FREE" ,
			RL_CAMERA_FIRST_PERSON => "FIRST_PERSON" ,
			RL_CAMERA_THIRD_PERSON => "THIRD_PERSON" ,
			RL_CAMERA_ORBITAL      => "ORBITAL",
			default                => "CUSTOM",
		};

		RL_DrawText( "- Mode: $CAMERA_MODE_NAME" , 610 , 30 , 10 , RL_BLACK );

		$CAMERA_PROJECTION_NAME = match( $CAMERA->projection )
		{
			RL_CAMERA_PERSPECTIVE  => "PERSPECTIVE" ,
			RL_CAMERA_ORTHOGRAPHIC => "ORTHOGRAPHIC" ,
			default                => "CUSTOM" ,
		};

		RL_DrawText( "- Projection: $CAMERA_PROJECTION_NAME" , 610 , 45 , 10 , RL_BLACK );
		RL_DrawText( RL_TextFormat( "- Position: (%06.3f, %06.3f, %06.3f)" ,
				$CAMERA->position->x ,
				$CAMERA->position->y ,
				$CAMERA->position->z ) , 610 , 60 , 10 , RL_BLACK );

		RL_DrawText( RL_TextFormat( "- Target: (%06.3f, %06.3f, %06.3f)" ,
				$CAMERA->target->x ,
				$CAMERA->target->y ,
				$CAMERA->target->z ) , 610 , 75 , 10 , RL_BLACK );
		RL_DrawText( RL_TextFormat( "- Up: (%06.3f, %06.3f, %06.3f)" ,
				$CAMERA->up->x ,
				$CAMERA->up->y ,
				$CAMERA->up->z ) , 610 , 90 , 10 , RL_BLACK );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
