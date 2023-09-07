<?php
//TAB=4


include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [shapes] example - collision area" );

$BOX_A = RL_Rectangle( 10 , RL_GetScreenHeight()/2.0 - 50 , 200 , 100 );
$BOX_A_SPEED_X = 4 ;

$BOX_B = RL_Rectangle( RL_GetScreenWidth()/2.0 - 30 , RL_GetScreenHeight()/2.0 - 30 , 60 , 60 );

$BOX_COLLISION = RL_Rectangle();

$SCREEN_UPPER_LIMIT = 40 ;   // Top menu limits

$PAUSE = false ;             // Movement pause
$COLLISION = false ;         // Collision detection

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	if ( ! $PAUSE ) $BOX_A->x += $BOX_A_SPEED_X ;

	// Bounce box on x screen limits
	if (
		( $BOX_A->x + $BOX_A->width ) >= RL_GetScreenWidth()
		||
		( $BOX_A->x <= 0 )
	){
		$BOX_A_SPEED_X *= -1 ;
	}

	// Update player-controlled-box (box02)
		$BOX_B->x = RL_GetMouseX() - $BOX_B->width /2 ;
		$BOX_B->y = RL_GetMouseY() - $BOX_B->height/2 ;

	// Make sure Box B does not go out of move area limits
	if ( ( $BOX_B->x + $BOX_B->width ) >= RL_GetScreenWidth() )
	{
		$BOX_B->x = RL_GetScreenWidth() - $BOX_B->width ;
	}
	else
	if ( $BOX_B->x <= 0 )
	{
		$BOX_B->x = 0 ;
	}

	if ( ( $BOX_B->y + $BOX_B->height ) >= RL_GetScreenHeight() )
	{
		$BOX_B->y = RL_GetScreenHeight() - $BOX_B->height;
	}
	else
	if ( $BOX_B->y <= $SCREEN_UPPER_LIMIT )
	{
		$BOX_B->y = $SCREEN_UPPER_LIMIT ;
	}

	// Check boxes collision
	$COLLISION = RL_CheckCollisionRecs( $BOX_A , $BOX_B );

	// Get collision rectangle (only on collision)
	if ( $COLLISION )
	{
		$BOX_COLLISION = RL_GetCollisionRec( $BOX_A , $BOX_B );
	}

	// Pause Box A movement
	if ( RL_IsKeyPressed( RL_KEY_SPACE ) )
	{
		$PAUSE = ! $PAUSE ;
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawRectangle( 0 , 0 , $SCREEN_W , $SCREEN_UPPER_LIMIT , $COLLISION ? RL_RED : RL_BLACK );

		RL_DrawRectangleRec( $BOX_A , RL_GOLD );
		RL_DrawRectangleRec( $BOX_B , RL_BLUE );

		if ( $COLLISION )
		{
			// Draw collision area
			RL_DrawRectangleRec( $BOX_COLLISION , RL_LIME );

			// Draw collision message
			RL_DrawText( "COLLISION!" , RL_GetScreenWidth()/2 - RL_MeasureText("COLLISION!", 20)/2 , $SCREEN_UPPER_LIMIT/2 - 10 , 20 , RL_BLACK );

			// Draw collision area
			RL_DrawText
			(
				RL_TextFormat( "Collision Area: %i" , (int)$BOX_COLLISION->width*(int)$BOX_COLLISION->height ) ,
				RL_GetScreenWidth()/2 - 100 ,
				$SCREEN_UPPER_LIMIT + 10 ,
				20 ,
				RL_BLACK
			);
		}

		// Draw help instructions
		RL_DrawText( "Press SPACE to PAUSE/RESUME" , 20 , $SCREEN_H - 35 , 20 , RL_LIGHTGRAY );

		RL_DrawFPS( 10 , 10 );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
