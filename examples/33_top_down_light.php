<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'MAX_BOXES'   , 20 );
define( 'MAX_SHADOWS' , MAX_BOXES*3 );
define( 'MAX_LIGHTS'  , 16 );

// Shadow geometry type
class ShadowGeometry
{
	public object $VERTICES ;

	function __construct()
	{
		$this->VERTICES = RL_Vector2_array( 4 );
	}
};

function ShadowGeometry_array( int $SIZE ) : array { $A = [] ; for( $i = 0 ; $i < $SIZE ; $i++ ) $A[ $i ] = new ShadowGeometry(); return $A ; }

// Light info type
class LightInfo
{
	public bool $ACTIVE = false ; // Is this light slot active?
	public bool $DIRTY  = false ; // Does this light need to be updated?
	public bool $VALID  = false ; // Is this light in a valid position?

	public object $POSITION ; //= RL_Vector2() ;
	public object $MASK     ; //= RL_RenderTexture() ;
	public float  $OUTER_RADIUS = 0.0 ; // The distance the light touches
	public object $BOUNDS   ; //= RL_Rectangle(); // A cached rectangle of the light bounds to help with culling

	public array  $SHADOWS  ; //= ShadowGeometry_array( MAX_SHADOWS );
	public int $SHADOW_COUNT = 0 ;

	function __construct()
	{
		$this->POSITION = RL_Vector2() ;
		$this->MASK     = RL_RenderTexture() ;
		$this->BOUNDS   = RL_Rectangle() ;

		$this->SHADOWS  = ShadowGeometry_array( MAX_SHADOWS ) ;
	}
};

function LightInfo_array( int $SIZE ) : array { $A = [] ; for( $i = 0 ; $i < $SIZE ; $i++ ) $A[ $i ] = new LightInfo(); return $A ; }

$LIGHTS = LightInfo_array( MAX_LIGHTS );

// Move a light and mark it as dirty so that we update it's mask next frame
function MoveLight( int $slot , float $x , float $y ) : void
{
	global $LIGHTS ;

	$LIGHTS[ $slot ]->DIRTY = true ;
	$LIGHTS[ $slot ]->POSITION->x = $x ;
	$LIGHTS[ $slot ]->POSITION->y = $y ;

	// update the cached bounds
	$LIGHTS[ $slot ]->BOUNDS->x = $x - $LIGHTS[ $slot ]->OUTER_RADIUS ;
	$LIGHTS[ $slot ]->BOUNDS->y = $y - $LIGHTS[ $slot ]->OUTER_RADIUS ;
}

// Compute a shadow volume for the edge
// It takes the edge and projects it back by the light radius and turns it into a quad
function ComputeShadowVolumeForEdge( int $slot , object $vec2_sp , object $vec2_ep ) : void
{
	global $LIGHTS ;

	if ( $LIGHTS[ $slot ]->SHADOW_COUNT >= MAX_SHADOWS ) return;

	$EXTENSION = $LIGHTS[ $slot ]->OUTER_RADIUS * 2;

	$SP_VECTOR = clone RL_Vector2Normalize( RL_Vector2Subtract( $vec2_sp , $LIGHTS[ $slot ]->POSITION ) );
	$SP_PROJECTION = clone RL_Vector2Add( $vec2_sp , RL_Vector2Scale( $SP_VECTOR , $EXTENSION ) );

	$EP_VECTOR = clone RL_Vector2Normalize( RL_Vector2Subtract( $vec2_ep , $LIGHTS[ $slot ]->POSITION ) );
	$EP_PROJECTION = clone RL_Vector2Add( $vec2_ep , RL_Vector2Scale( $EP_VECTOR , $EXTENSION ) );

	$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[0] = clone $vec2_sp ;
	$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[1] = clone $vec2_ep ;
	$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[2] = $EP_PROJECTION ;
	$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[3] = $SP_PROJECTION ;

	$LIGHTS[ $slot ]->SHADOW_COUNT++ ;
}

// Draw the light and shadows to the mask for a light
function DrawLightMask( int $slot ) : void
{
	global $LIGHTS ;

	// Use the light mask
	RL_BeginTextureMode( $LIGHTS[ $slot ]->MASK );

		RL_ClearBackground( RL_WHITE );

		// Force the blend mode to only set the alpha of the destination
		RL_rlSetBlendFactors( RLGL_SRC_ALPHA , RLGL_SRC_ALPHA , RLGL_MIN );
		RL_rlSetBlendMode( RLGL_BLEND_CUSTOM );

		// If we are valid, then draw the light radius to the alpha mask
		if ( $LIGHTS[ $slot ]->VALID )
		{
			RL_DrawCircleGradient( $LIGHTS[ $slot ]->POSITION->x , $LIGHTS[ $slot ]->POSITION->y , $LIGHTS[ $slot ]->OUTER_RADIUS , RL_ColorAlpha( RL_WHITE , 0 ) , RL_WHITE );
		}

		RL_rlDrawRenderBatchActive();

		// Cut out the shadows from the light radius by forcing the alpha to maximum
		RL_rlSetBlendMode( RLGL_BLEND_ALPHA );
		RL_rlSetBlendFactors( RLGL_SRC_ALPHA , RLGL_SRC_ALPHA , RLGL_MAX );
		RL_rlSetBlendMode( RLGL_BLEND_CUSTOM );

		// Draw the shadows to the alpha mask
		for( $i = 0 ; $i < $LIGHTS[ $slot ]->SHADOW_COUNT ; $i++ )
		{
			RL_DrawTriangleFan( $LIGHTS[ $slot ]->SHADOWS[ $i ]->VERTICES , 4 , RL_WHITE );
		}

		RL_rlDrawRenderBatchActive();

		// Go back to normal blend mode
		RL_rlSetBlendMode( RLGL_BLEND_ALPHA );

	RL_EndTextureMode();
}

// Setup a light
function SetupLight( int $slot , float $x , float $y , float $radius ) : void
{
	global $LIGHTS ;

	$LIGHTS[ $slot ]->ACTIVE = true  ;
	$LIGHTS[ $slot ]->VALID  = false ;  // The light must prove it is valid
	$LIGHTS[ $slot ]->MASK = RL_LoadRenderTexture( RL_GetScreenWidth() , RL_GetScreenHeight() );
	$LIGHTS[ $slot ]->OUTER_RADIUS = $radius ;

	$LIGHTS[ $slot ]->BOUNDS->width  = $radius * 2 ;
	$LIGHTS[ $slot ]->BOUNDS->height = $radius * 2 ;

	MoveLight( $slot , $x , $y );

	// Force the render texture to have something in it
	DrawLightMask( $slot );
}

// See if a light needs to update it's mask
function UpdateLight( int $slot , object $boxes , int $count ) : bool
{
	global $LIGHTS ;

	if (! $LIGHTS[ $slot ]->ACTIVE || ! $LIGHTS[ $slot ]->DIRTY ) return false ;

	$LIGHTS[ $slot ]->DIRTY = false ;
	$LIGHTS[ $slot ]->SHADOW_COUNT = 0 ;
	$LIGHTS[ $slot ]->VALID = false ;

	for( $i = 0 ; $i < $count ; $i++ )
	{
		// Are we in a box? if so we are not valid
		if ( RL_CheckCollisionPointRec( $LIGHTS[ $slot ]->POSITION , $boxes[ $i ] ) ) return false ;

		// If this box is outside our bounds, we can skip it
		if ( ! RL_CheckCollisionRecs( $LIGHTS[ $slot ]->BOUNDS , $boxes[ $i ] ) ) continue;

		// Check the edges that are on the same side we are, and cast shadow volumes out from them

		// Top
		$SP = RL_Vector2( $boxes[ $i ]->x                       , $boxes[ $i ]->y ) ;
		$EP = RL_Vector2( $boxes[ $i ]->x + $boxes[ $i ]->width , $boxes[ $i ]->y ) ;

		if ( $LIGHTS[ $slot ]->POSITION->y > $EP->y ) ComputeShadowVolumeForEdge( $slot , $SP , $EP );

		// Right
		$SP = clone $EP ;
		$EP->y += $boxes[ $i ]->height ;
		if ( $LIGHTS[ $slot ]->POSITION->x < $EP->x ) ComputeShadowVolumeForEdge( $slot , $SP , $EP );

		// Bottom
		$SP = clone $EP ;
		$EP->x -= $boxes[ $i ]->width ;
		if ( $LIGHTS[ $slot ]->POSITION->y < $EP->y ) ComputeShadowVolumeForEdge( $slot , $SP , $EP );

		// Left
		$SP = clone $EP ;
		$EP->y -= $boxes[ $i ]->height ;
		if ( $LIGHTS[ $slot ]->POSITION->x > $EP->x ) ComputeShadowVolumeForEdge( $slot , $SP , $EP );

		// The box itself
		$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[0] = RL_Vector2( $boxes[ $i ]->x                       , $boxes[ $i ]->y                        );
		$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[1] = RL_Vector2( $boxes[ $i ]->x                       , $boxes[ $i ]->y + $boxes[ $i ]->height );
		$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[2] = RL_Vector2( $boxes[ $i ]->x + $boxes[ $i ]->width , $boxes[ $i ]->y + $boxes[ $i ]->height );
		$LIGHTS[ $slot ]->SHADOWS[ $LIGHTS[ $slot ]->SHADOW_COUNT ]->VERTICES[3] = RL_Vector2( $boxes[ $i ]->x + $boxes[ $i ]->width , $boxes[ $i ]->y                        );

		$LIGHTS[ $slot ]->SHADOW_COUNT++ ;
	}

	$LIGHTS[ $slot ]->VALID = true ;

	DrawLightMask( $slot );

	return true;
}

// Set up some boxes
function SetupBoxes( object $boxes ) : int
{
	$boxes[0] = RL_Rectangle(  150 ,  80 , 40 , 40 );
	$boxes[1] = RL_Rectangle( 1200 , 700 , 40 , 40 );
	$boxes[2] = RL_Rectangle(  200 , 600 , 40 , 40 );
	$boxes[3] = RL_Rectangle( 1000 ,  50 , 40 , 40 );
	$boxes[4] = RL_Rectangle(  500 , 350 , 40 , 40 );

	for ( $i = 5 ; $i < MAX_BOXES ; $i++ )
	{
		$boxes[ $i ] = RL_Rectangle
		(
			RL_GetRandomValue(  0 , RL_GetScreenWidth() ) ,
			RL_GetRandomValue(  0 , RL_GetScreenHeight() ) ,
			RL_GetRandomValue( 10 , 100 ) ,
			RL_GetRandomValue( 10 , 100 ) ,
		);
	}

	return MAX_BOXES ;
}

//------------------------------------------------------------------------------------
// Program main entry point
//------------------------------------------------------------------------------------

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [shapes] example - top down lights" );

// Initialize our 'world' of boxes

$BOXES = RL_Rectangle_array( MAX_BOXES );
$BOX_COUNT = SetupBoxes( $BOXES );

// Create a checkerboard ground texture
$IMG = RL_GenImageChecked( 64 , 64 , 32 , 32 , RL_DARKBROWN , RL_DARKGRAY );
$BACKGROUND_TEXTURE = RL_LoadTextureFromImage( $IMG );
RL_UnloadImage( $IMG );
unset( $IMG );

// Create a global light mask to hold all the blended lights
$LIGHT_MASK = RL_LoadRenderTexture( RL_GetScreenWidth() , RL_GetScreenHeight() );

// Setup initial light
SetupLight( 0 , 600 , 400 , 300 );
$NEXT_LIGHT = 1 ;

$SHOW_LINES = false ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	// Drag light 0
	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_LEFT ) ) MoveLight( 0 , RL_GetMousePosition()->x , RL_GetMousePosition()->y );

	// Make a new light
	if ( RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_RIGHT ) && ( $NEXT_LIGHT < MAX_LIGHTS ) )
	{
		SetupLight( $NEXT_LIGHT , RL_GetMousePosition()->x , RL_GetMousePosition()->y , 200 );
		$NEXT_LIGHT++;
	}

	// Toggle debug info
	if ( RL_IsKeyPressed( RL_KEY_F1 ) ) $SHOW_LINES = ! $SHOW_LINES ;

	// Update the lights and keep track if any were dirty so we know if we need to update the master light mask
	$DIRTY_LIGHTS = false ;
	for ( $i = 0 ; $i < MAX_LIGHTS ; $i++ )
	{
		if ( UpdateLight( $i , $BOXES , $BOX_COUNT ) ) $DIRTY_LIGHTS = true ;
	}

	// Update the light mask
	if ( $DIRTY_LIGHTS )
	{
		// Build up the light mask
		RL_BeginTextureMode( $LIGHT_MASK );

			RL_ClearBackground( RL_BLACK );

			// Force the blend mode to only set the alpha of the destination
			RL_rlSetBlendFactors( RLGL_SRC_ALPHA , RLGL_SRC_ALPHA , RLGL_MIN );
			RL_rlSetBlendMode( RLGL_BLEND_CUSTOM );

			// Merge in all the light masks
			for( $i = 0 ; $i < MAX_LIGHTS ; $i++ )
			{
				if ( $LIGHTS[ $i ]->ACTIVE )
				{
					RL_DrawTextureRec( $LIGHTS[ $i ]->MASK->texture , RL_Rectangle( 0 , 0 , RL_GetScreenWidth() , -RL_GetScreenHeight() ) , RL_Vector2Zero() , RL_WHITE );
				}
			}

			RL_rlDrawRenderBatchActive();

			// Go back to normal blend
			RL_rlSetBlendMode( RLGL_BLEND_ALPHA);
		RL_EndTextureMode();
	}


	RL_BeginDrawing();

		RL_ClearBackground( RL_BLACK );

		// Draw the tile background
		RL_DrawTextureRec( $BACKGROUND_TEXTURE , RL_Rectangle( 0 , 0 , RL_GetScreenWidth() , RL_GetScreenHeight() ) , RL_Vector2Zero() , RL_WHITE );

		// Overlay the shadows from all the lights
		RL_DrawTextureRec
		(
			$LIGHT_MASK->texture ,
			RL_Rectangle( 0 , 0 , RL_GetScreenWidth() , -RL_GetScreenHeight() ) ,
			RL_Vector2Zero() ,
			RL_ColorAlpha( RL_WHITE , $SHOW_LINES ? 0.75  : 1.0 )
		);

		// Draw the lights
		for ( $i = 0 ; $i < MAX_LIGHTS ; $i++ )
		{
			if ( $LIGHTS[ $i ]->ACTIVE )
			{
				RL_DrawCircle( $LIGHTS[ $i ]->POSITION->x , $LIGHTS[ $i ]->POSITION->y , 10 , ( $i == 0 ) ? RL_YELLOW : RL_WHITE );
			}
		}

		if ( $SHOW_LINES )
		{
			for ( $s = 0 ; $s < $LIGHTS[0]->SHADOW_COUNT ; $s++ )
			{
				RL_DrawTriangleFan( $LIGHTS[0]->SHADOWS[ $s ]->VERTICES , 4 , RL_DARKPURPLE );
			}

			for ( $b = 0 ; $b < $BOX_COUNT ; $b++ )
			{
				if ( RL_CheckCollisionRecs( $BOXES[ $b ] , $LIGHTS[0]->BOUNDS ) ) RL_DrawRectangleRec( $BOXES[ $b ] , RL_PURPLE );

				RL_DrawRectangleLines
				(
					$BOXES[ $b ]->x ,
					$BOXES[ $b ]->y ,
					$BOXES[ $b ]->width ,
					$BOXES[ $b ]->height ,
					RL_DARKBLUE
				);
			}

			RL_DrawText( "(F1) Hide Shadow Volumes" , 10 , 50 , 10 , RL_GREEN );
		}
		else
		{
			RL_DrawText( "(F1) Show Shadow Volumes" , 10 , 50 , 10 , RL_GREEN );
		}

		RL_DrawFPS( $SCREEN_W - 80 , 10 );
		RL_DrawText( "Drag to move light #1" , 10 , 10 , 10 , RL_DARKGREEN );
		RL_DrawText( "Right click to add new light" , 10 , 30 , 10 , RL_DARKGREEN );
	RL_EndDrawing();
}

RL_UnloadTexture( $BACKGROUND_TEXTURE );
RL_UnloadRenderTexture( $LIGHT_MASK );
for( $i = 0 ; $i < MAX_LIGHTS ; $i++ )
{
	if ( $LIGHTS[ $i ]->ACTIVE ) RL_UnloadRenderTexture( $LIGHTS[ $i ]->MASK );
}

RL_CloseWindow();

//EOF
