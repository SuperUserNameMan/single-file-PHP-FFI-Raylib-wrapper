<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$CAMERA_P1 = RL_Camera();
$CAMERA_P2 = RL_Camera();

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

function DrawScene() : void
{
	global $CAMERA_P1 ;
	global $CAMERA_P2 ;

	$COUNT   = 5 ;
	$SPACING = 4.0 ;

	// Grid of cube trees on a plane to make a "world"
	RL_DrawPlane( RL_Vector3( 0, 0, 0 ) , RL_Vector2( 50, 50 ) , RL_BEIGE ); // Simple world plane

	for ( $x = -$COUNT*$SPACING ; $x <= $COUNT*$SPACING ; $x += $SPACING )
	{
		for ( $z = -$COUNT*$SPACING ; $z <= $COUNT*$SPACING ; $z += $SPACING )
		{
			RL_DrawCube( RL_Vector3( $x , 1.5 , $z ) , 1.0  , 1.0 , 1.0  , RL_LIME  );
			RL_DrawCube( RL_Vector3( $x , 0.5 , $z ) , 0.25 , 1.0 , 0.25 , RL_BROWN );
		}
	}

	// Draw a cube at each player's position
	RL_DrawCube( $CAMERA_P1->position , 1 , 1 , 1 , RL_RED  );
	RL_DrawCube( $CAMERA_P2->position , 1 , 1 , 1 , RL_BLUE );
}


RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - split screen" );

// Setup player 1 camera and screen
$CAMERA_P1->fovy        = 45.0 ;
$CAMERA_P1->up->y       =  1.0 ;
$CAMERA_P1->target->y   =  1.0 ;
$CAMERA_P1->position->z = -3.0 ;
$CAMERA_P1->position->y =  1.0 ;

$SCREEN_P1 = RL_LoadRenderTexture( $SCREEN_W/2 , $SCREEN_H );

// Setup player two camera and screen
$CAMERA_P2->fovy        = 45.0 ;
$CAMERA_P2->up->y       =  1.0 ;
$CAMERA_P2->target->y   =  3.0 ;
$CAMERA_P2->position->z = -3.0 ;
$CAMERA_P2->position->y =  3.0 ;

$SCREEN_P2 = RL_LoadRenderTexture( $SCREEN_W/2 , $SCREEN_H );

// Build a flipped rectangle the size of the split view to use for drawing later
$SPLIT_SCREEN_RECT = RL_Rectangle( 0.0 , 0.0 , $SCREEN_P1->texture->width , -$SCREEN_P1->texture->height );

RL_SetTargetFPS( 60 );

while ( ! RL_WindowShouldClose() )
{
	$OFFSET_THIS_FRAME = 10.0 * RL_GetFrameTime() ;

	// Move Player1 forward and backwards (no turning)
	if ( RL_IsKeyDown( RL_KEY_W ) )
	{
		$CAMERA_P1->position->z += $OFFSET_THIS_FRAME ;
		$CAMERA_P1->target->z   += $OFFSET_THIS_FRAME ;
	}
	else
	if ( RL_IsKeyDown( RL_KEY_S ) )
	{
		$CAMERA_P1->position->z -= $OFFSET_THIS_FRAME ;
		$CAMERA_P1->target->z   -= $OFFSET_THIS_FRAME ;
	}

	// Move Player2 forward and backwards (no turning)
	if ( RL_IsKeyDown( RL_KEY_UP ) )
	{
		$CAMERA_P2->position->x += $OFFSET_THIS_FRAME ;
		$CAMERA_P2->target->x   += $OFFSET_THIS_FRAME ;
	}
	else
	if ( RL_IsKeyDown( RL_KEY_DOWN ) )
	{
		$CAMERA_P2->position->x -= $OFFSET_THIS_FRAME ;
		$CAMERA_P2->target->x   -= $OFFSET_THIS_FRAME ;
	}

	// Draw Player1 view to the render texture
	RL_BeginTextureMode( $SCREEN_P1 );
		RL_ClearBackground( RL_SKYBLUE );
		RL_BeginMode3D( $CAMERA_P1 );
			DrawScene();
		RL_EndMode3D();
		RL_DrawText( "PLAYER1 W/S to move" , 10 , 10 , 20 , RL_RED );
	RL_EndTextureMode();

	// Draw Player2 view to the render texture
	RL_BeginTextureMode( $SCREEN_P2 );
		RL_ClearBackground( RL_SKYBLUE );
		RL_BeginMode3D( $CAMERA_P2 );
			DrawScene();
		RL_EndMode3D();
		RL_DrawText( "PLAYER2 UP/DOWN to move" , 10 , 10 , 20 , RL_BLUE );
	RL_EndTextureMode();

	// Draw both views render textures to the screen side by side
	RL_BeginDrawing();
		RL_ClearBackground( RL_BLACK );
		RL_DrawTextureRec( $SCREEN_P1->texture , $SPLIT_SCREEN_RECT , RL_Vector2( 0 , 0 ) , RL_WHITE );
		RL_DrawTextureRec( $SCREEN_P2->texture , $SPLIT_SCREEN_RECT , RL_Vector2( $SCREEN_W / 2 , 0 ), RL_WHITE );
	RL_EndDrawing();
}


RL_UnloadRenderTexture( $SCREEN_P1 );
RL_UnloadRenderTexture( $SCREEN_P2 );

RL_CloseWindow();

//EOF
