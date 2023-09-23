<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SHOW_CURVE = false ;
$CURVE_WIDTH = 50 ;
$CURVE_SEGMENTS = 24 ;

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_SetConfigFlags( RL_FLAG_VSYNC_HINT | RL_FLAG_MSAA_4X_HINT );
RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] examples - textured curve" );


$TEXTURE_ROAD = RL_LoadTexture( './raylib/examples/resources/road.png' );
RL_SetTextureFilter( $TEXTURE_ROAD , RL_TEXTURE_FILTER_TRILINEAR );

$CURVE_START_POSITION  = RL_Vector2(  80 , 100 );
$CURVE_START_TANGENT   = RL_Vector2( 100 , 300 );

$CURVE_END_POSITION    = RL_Vector2( 700 , 350 );
$CURVE_END_TANGENT     = RL_Vector2( 600 , 100 );

$CURVE_SELECTED_POINT  = null ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	UpdateCurve();
	UpdateOptions();

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );
		DrawTexturedCurve();
		DrawCurve();

		RL_DrawText( "Drag points to move curve, press SPACE to show/hide base curve" , 10 , 10 , 10 , RL_DARKGRAY );
		RL_DrawText( RL_TextFormat( "Curve width: %2.0f (Use UP and DOWN to adjust)" , (float)$CURVE_WIDTH ) , 10 , 30 , 10 , RL_DARKGRAY );
		RL_DrawText( RL_TextFormat( "Curve segments: %d (Use LEFT and RIGHT to adjust)" , (int)$CURVE_SEGMENTS ) , 10 , 50 , 10 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE_ROAD );
RL_CloseWindow();

function DrawCurve() : void
{
	global $SHOW_CURVE ;
	global $CURVE_START_POSITION ;
	global $CURVE_START_TANGENT  ;
	global $CURVE_END_POSITION   ;
	global $CURVE_END_TANGENT    ;

	if ( $SHOW_CURVE )
	{
		RL_DrawLineBezierCubic( $CURVE_START_POSITION , $CURVE_END_POSITION , $CURVE_START_TANGENT , $CURVE_END_TANGENT , 2 , RL_BLUE );
	}

	// Draw the various control points and highlight where the mouse is
	RL_DrawLineV( $CURVE_START_POSITION , $CURVE_START_TANGENT , RL_SKYBLUE );
	RL_DrawLineV( $CURVE_END_POSITION   , $CURVE_END_TANGENT   , RL_PURPLE  );

	$MOUSE = RL_GetMousePosition();

	if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_START_POSITION , 6 ) ) RL_DrawCircleV( $CURVE_START_POSITION , 7 , RL_YELLOW );
	if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_START_TANGENT  , 6 ) ) RL_DrawCircleV( $CURVE_START_TANGENT  , 7 , RL_YELLOW );
	if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_END_POSITION   , 6 ) ) RL_DrawCircleV( $CURVE_END_POSITION   , 7 , RL_YELLOW );
	if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_END_TANGENT    , 6 ) ) RL_DrawCircleV( $CURVE_END_TANGENT    , 7 , RL_YELLOW );

	RL_DrawCircleV( $CURVE_START_POSITION , 5 , RL_RED       );
	RL_DrawCircleV( $CURVE_START_TANGENT  , 5 , RL_MAROON    );
	RL_DrawCircleV( $CURVE_END_POSITION   , 5 , RL_GREEN     );
	RL_DrawCircleV( $CURVE_END_TANGENT    , 5 , RL_DARKGREEN );
}

function UpdateCurve() : void
{
	global $CURVE_START_POSITION ;
	global $CURVE_START_TANGENT  ;
	global $CURVE_END_POSITION   ;
	global $CURVE_END_TANGENT    ;
	global $CURVE_SELECTED_POINT ;

	// If the mouse is not down, we are not editing the curve so clear the selection
	if ( ! RL_IsMouseButtonDown( RL_MOUSE_BUTTON_LEFT ) )
	{
		$CURVE_SELECTED_POINT = null ;
		return ;
	}

	// If a point was selected, move it
	if ( ! empty( $CURVE_SELECTED_POINT ) )
	{
		$$CURVE_SELECTED_POINT = RL_Vector2Add( $$CURVE_SELECTED_POINT , RL_GetMouseDelta() );
		return;
	}

	// The mouse is down, and nothing was selected, so see if anything was picked
	$MOUSE = RL_GetMousePosition();

	if      ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_START_POSITION , 6 ) ) $CURVE_SELECTED_POINT = 'CURVE_START_POSITION' ;
	else if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_START_TANGENT  , 6 ) ) $CURVE_SELECTED_POINT = 'CURVE_START_TANGENT'  ;
	else if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_END_POSITION   , 6 ) ) $CURVE_SELECTED_POINT = 'CURVE_END_POSITION'   ;
	else if ( RL_CheckCollisionPointCircle( $MOUSE , $CURVE_END_TANGENT    , 6 ) ) $CURVE_SELECTED_POINT = 'CURVE_END_TANGENT'    ;
}

function DrawTexturedCurve()
{
	global $CURVE_SEGMENTS;
	global $CURVE_START_POSITION ;
	global $CURVE_START_TANGENT  ;
	global $CURVE_END_POSITION   ;
	global $CURVE_END_TANGENT    ;
	global $CURVE_WIDTH ;
	global $TEXTURE_ROAD ;

	$STEP = 1.0 / $CURVE_SEGMENTS ;

	$PREVIOUS         = $CURVE_START_POSITION ;
	$PREVIOUS_TANGENT = RL_Vector2();
	$PREVIOUS_V       = 0.0 ;

	// We can't compute a tangent for the first point, so we need to reuse the tangent from the first segment
	$TANGENT_SET = false;

	$CURRENT = RL_Vector2();
	$t = 0.0 ;

	for( $i = 1 ; $i <= $CURVE_SEGMENTS ; $i++ )
	{
		// Segment the curve
		$t = $STEP*$i ;
		$a = pow( 1.0 - $t , 3.0 );
		$b = 3.0*pow( 1.0 - $t , 2.0 ) * $t;
		$c = 3.0*( 1.0 - $t )*pow( $t , 2.0 );
		$d = pow( $t , 3.0 );

		// Compute the endpoint for this segment
		$CURRENT->x = $a*$CURVE_START_POSITION->x + $b*$CURVE_START_TANGENT->x + $c*$CURVE_END_TANGENT->x + $d*$CURVE_END_POSITION->x ;
		$CURRENT->y = $a*$CURVE_START_POSITION->y + $b*$CURVE_START_TANGENT->y + $c*$CURVE_END_TANGENT->y + $d*$CURVE_END_POSITION->y ;


		// Vector from previous to current
		$DELTA = RL_Vector2( $CURRENT->x - $PREVIOUS->x , $CURRENT->y - $PREVIOUS->y ) ;

		// The right hand normal to the delta vector
		$NORMAL = RL_Vector2Normalize( RL_Vector2( -$DELTA->y , $DELTA->x ) );

		// The v texture coordinate of the segment (add up the length of all the segments so far)
		$V = $PREVIOUS_V + RL_Vector2Length( $DELTA ) / ( $CURVE_WIDTH * 2 ) ;

		// Make sure the start point has a normal
		if ( ! $TANGENT_SET )
		{
			$PREVIOUS_TANGENT = clone $NORMAL ;
			$TANGENT_SET = true ;
		}

		// Extend out the normals from the previous and current points to get the quad for this segment
		$PREV_POS_NORMAL = RL_Vector2Add( $PREVIOUS , RL_Vector2Scale( $PREVIOUS_TANGENT ,  $CURVE_WIDTH ) );
		$PREV_NEG_NORMAL = RL_Vector2Add( $PREVIOUS , RL_Vector2Scale( $PREVIOUS_TANGENT , -$CURVE_WIDTH ) );

		$CURRENT_POS_NORMAL = RL_Vector2Add( $CURRENT , RL_Vector2Scale( $NORMAL ,  $CURVE_WIDTH ) );
		$CURRENT_NEG_NORMAL = RL_Vector2Add( $CURRENT , RL_Vector2Scale( $NORMAL , -$CURVE_WIDTH ) );

		// Draw the segment as a quad
		RL_rlSetTexture( $TEXTURE_ROAD->id );
		RL_rlBegin( RLGL_QUADS );

			RL_rlColor4ub( 255 , 255 , 255 , 255 );
			RL_rlNormal3f( 0.0 , 0.0 , 1.0 );

			RL_rlTexCoord2f( 0.0 , $PREVIOUS_V );
			RL_rlVertex2f( $PREV_NEG_NORMAL->x , $PREV_NEG_NORMAL->y );

			RL_rlTexCoord2f( 1.0 , $PREVIOUS_V );
			RL_rlVertex2f( $PREV_POS_NORMAL->x , $PREV_POS_NORMAL->y );

			RL_rlTexCoord2f( 1.0 , $V );
			RL_rlVertex2f( $CURRENT_POS_NORMAL->x , $CURRENT_POS_NORMAL->y );

			RL_rlTexCoord2f( 0.0 , $V );
			RL_rlVertex2f( $CURRENT_NEG_NORMAL->x , $CURRENT_NEG_NORMAL->y );

		RL_rlEnd();

		// The current step is the start of the next step
		$PREVIOUS = clone $CURRENT ; // <== XXX
		$PREVIOUS_TANGENT = $NORMAL ;
		$PREVIOUS_V = $V ;
	}
}

function UpdateOptions() : void
{
	global $SHOW_CURVE ;
	global $CURVE_WIDTH ;
	global $CURVE_SEGMENTS ;

	if ( RL_IsKeyPressed( RL_KEY_SPACE ) ) $SHOW_CURVE = ! $SHOW_CURVE ;

	// Update with
	if ( RL_IsKeyPressed( RL_KEY_UP   ) ) $CURVE_WIDTH += 2 ;
	if ( RL_IsKeyPressed( RL_KEY_DOWN ) ) $CURVE_WIDTH -= 2 ;

	if ( $CURVE_WIDTH < 2 ) $CURVE_WIDTH = 2 ;

	// Update segments
	if ( RL_IsKeyPressed( RL_KEY_LEFT  ) ) $CURVE_SEGMENTS -= 2 ;
	if ( RL_IsKeyPressed( RL_KEY_RIGHT ) ) $CURVE_SEGMENTS += 2 ;

	if ( $CURVE_SEGMENTS < 2 ) $CURVE_SEGMENTS = 2 ;
}

//EOF
