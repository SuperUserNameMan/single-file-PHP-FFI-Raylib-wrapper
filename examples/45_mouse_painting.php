<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - mouse painting" );

$COLORS = [
	RL_RAYWHITE , RL_YELLOW , RL_GOLD , RL_ORANGE , RL_PINK , RL_RED , RL_MAROON , RL_GREEN , RL_LIME , RL_DARKGREEN ,
	RL_SKYBLUE , RL_BLUE , RL_DARKBLUE , RL_PURPLE , RL_VIOLET , RL_DARKPURPLE , RL_BEIGE , RL_BROWN , RL_DARKBROWN ,
	RL_LIGHTGRAY , RL_GRAY , RL_DARKGRAY , RL_BLACK ,
];

$COLORS_RECS = [];

for( $i = 0 ; $i < count( $COLORS ) ; $i++ )
{
	$COLORS_RECS[ $i ] = RL_Rectangle
	([
		'x' => 10 + 30.0*$i + 2*$i ,
		'y' => 10 ,
		'width' => 30 ,
		'height' => 30 ,
	]);
}

$COLOR_SELECTED       = 0 ;
$COLOR_SELECTED_PREV  = $COLOR_SELECTED ;
$COLOR_MOUSE_HOVER    = 0 ;
$BRUSH_SIZE           = 20.0 ;
$MOUSE_WAS_PRESSED    = false ;

$BTN_SAVE_REC         = Rl_Rectangle( 750 , 10 , 40 , 30 );
$BTN_SAVE_MOUSE_HOVER = false ;
$SHOW_SAVE_MESSAGE    = false ;
$SAVE_MESSAGE_COUNTER = 0 ;

$TARGET = Rl_LoadRenderTexture( $SCREEN_W , $SCREEN_H );

RL_BeginTextureMode( $TARGET );
	RL_ClearBackground( $COLORS[ 0 ] );
RL_EndTextureMode();

RL_SetTargetFPS( 120 );

while( ! RL_WindowShouldClose() )
{
	$MOUSE_POS = RL_GetMousePosition();

	if ( RL_IsKeyPressed( RL_KEY_RIGHT ) ) $COLOR_SELECTED++;
	else
	if ( RL_IsKeyPressed( RL_KEY_LEFT  ) ) $COLOR_SELECTED--;

	if ( $COLOR_SELECTED >= count( $COLORS ) ) $COLOR_SELECTED = count( $COLORS ) - 1;
	else
	if ( $COLOR_SELECTED < 0 ) $COLOR_SELECTED = 0 ;

	for( $i = 0 ; $i < count( $COLORS ) ; $i++ )
	{
		if ( RL_CheckCollisionPointRec( $MOUSE_POS , $COLORS_RECS[ $i ] ) )
		{
			$COLOR_MOUSE_HOVER = $i ;
			break;
		}
		else $COLOR_MOUSE_HOVER = -1 ;
	}

	if ( ( $COLOR_MOUSE_HOVER >= 0 ) && RL_IsMouseButtonPressed( RL_MOUSE_BUTTON_LEFT ) )
	{
		$COLOR_SELECTED = $COLOR_MOUSE_HOVER ;
		$COLOR_SELECTED_PREV = $COLOR_SELECTED ;
	}

	$BRUSH_SIZE += RL_GetMouseWheelMove()*5;
	if ( $BRUSH_SIZE < 2  ) $BRUSH_SIZE =  2 ;
	if ( $BRUSH_SIZE > 50 ) $BRUSH_SIZE = 50 ;

	if ( RL_IsKeyPressed( RL_KEY_C ) )
	{
		RL_BeginTextureMode( $TARGET );
			RL_ClearBackground( $COLORS[ $COLOR_SELECTED ] );
		RL_EndTextureMode();
	}

	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_LEFT ) || ( RL_GetGestureDetected() == RL_GESTURE_DRAG ) )
	{
		RL_BeginTextureMode( $TARGET );
			if ( $MOUSE_POS->y > 50 )
			{
				RL_DrawCircle( (int)$MOUSE_POS->x , (int)$MOUSE_POS->y , $BRUSH_SIZE , $COLORS[ $COLOR_SELECTED ] );
			}
		RL_EndTextureMode();
	}

	if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_RIGHT ) ) // Eraser
	{
		if ( ! $MOUSE_WAS_PRESSED )
		{
			$COLOR_SELECTED_PREV = $COLOR_SELECTED ;
			$COLOR_SELECTED = 0 ;
		}

		$MOUSE_WAS_PRESSED = true ;

		RL_BeginTextureMode( $TARGET );
			if ( $MOUSE_POS->y > 50 )
			{
				RL_DrawCircle( (int)$MOUSE_POS->x , (int)$MOUSE_POS->y, $BRUSH_SIZE , $COLORS[0] );
			}
		RL_EndTextureMode();
	}
	else
	if ( RL_IsMouseButtonReleased( RL_MOUSE_BUTTON_RIGHT ) && $MOUSE_WAS_PRESSED )
	{
		$COLOR_SELECTED = $COLOR_SELECTED_PREV ;
		$MOUSE_WAS_PRESSED = false ;
	}

	// Check mouse hover save button
	$BTN_SAVE_MOUSE_HOVER = RL_CheckCollisionPointRec( $MOUSE_POS , $BTN_SAVE_REC );

	// Image saving logic
	// NOTE: Saving painted texture to a default named image
	if ( ( $BTN_SAVE_MOUSE_HOVER && RL_IsMouseButtonReleased( RL_MOUSE_BUTTON_LEFT ) ) || RL_IsKeyPressed( RL_KEY_S ) )
	{
		$IMAGE = RL_LoadImageFromTexture( $TARGET->texture );
		RL_ImageFlipVertical( $IMAGE );
		RL_ExportImage( $IMAGE , "my_amazing_texture_painting.png" );
		RL_UnloadImage( $IMAGE );
		$SHOW_SAVE_MESSAGE = true;
	}

	if ( $SHOW_SAVE_MESSAGE )
	{
		// On saving, show a full screen message for 2 seconds
		$SAVE_MESSAGE_COUNTER++;
		if ( $SAVE_MESSAGE_COUNTER > 240 )
		{
			$SHOW_SAVE_MESSAGE    = false;
			$SAVE_MESSAGE_COUNTER = 0;
		}
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		// NOTE: Render texture must be y-flipped due to default OpenGL coordinates (left-bottom)
		RL_DrawTextureRec
		(
			$TARGET->texture ,
			RL_Rectangle( 0 , 0 , $TARGET->texture->width , -$TARGET->texture->height ) ,
			RL_Vector2  ( 0 , 0  ) ,
			RL_WHITE ,
		);

	// Draw drawing circle for reference
	if ( $MOUSE_POS->y > 50 )
	{
		if ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_RIGHT ) )
		{
			RL_DrawCircleLines( (int)$MOUSE_POS->x , (int)$MOUSE_POS->y , $BRUSH_SIZE , RL_GRAY );
		}
		else
		{
			RL_DrawCircle( RL_GetMouseX() , RL_GetMouseY() , $BRUSH_SIZE , $COLORS[ $COLOR_SELECTED ] );
		}
	}

	// Draw top panel
	RL_DrawRectangle( 0 , 0 , RL_GetScreenWidth() , 50 , RL_RAYWHITE );
	RL_DrawLine( 0 , 50 , RL_GetScreenWidth() , 50 , RL_LIGHTGRAY );

	// Draw color selection rectangles
	for( $i = 0 ; $i < count( $COLORS ); $i++ ) RL_DrawRectangleRec( $COLORS_RECS[ $i ] , $COLORS[ $i ] );
	RL_DrawRectangleLines( 10 , 10 , 30 , 30 , RL_LIGHTGRAY );

	if ( $COLOR_MOUSE_HOVER >= 0 ) RL_DrawRectangleRec( $COLORS_RECS[ $COLOR_MOUSE_HOVER ] , RL_Fade( RL_WHITE , 0.6 ) );

	RL_DrawRectangleLinesEx
	(
		RL_Rectangle
		(
			$COLORS_RECS[ $COLOR_SELECTED ]->x - 2 ,
			$COLORS_RECS[ $COLOR_SELECTED ]->y - 2 ,
			$COLORS_RECS[ $COLOR_SELECTED ]->width  + 4 ,
			$COLORS_RECS[ $COLOR_SELECTED ]->height + 4 ,
		),
		2 ,
		RL_BLACK ,
	);

	// Draw save image button
	RL_DrawRectangleLinesEx( $BTN_SAVE_REC , 2,  $BTN_SAVE_MOUSE_HOVER ? RL_RED : RL_BLACK );
	RL_DrawText( "SAVE!" , 755 , 20 , 10 , $BTN_SAVE_MOUSE_HOVER ? RL_RED : RL_BLACK );

	// Draw save image message
	if ( $SHOW_SAVE_MESSAGE )
	{
		RL_DrawRectangle( 0 ,   0 , RL_GetScreenWidth() , RL_GetScreenHeight() , RL_Fade( RL_RAYWHITE , 0.8 ) );
		RL_DrawRectangle( 0 , 150 , RL_GetScreenWidth() , 80 , RL_BLACK );
		RL_DrawText( "IMAGE SAVED:  my_amazing_texture_painting.png" , 150 , 180 , 20 , RL_RAYWHITE );
	}

	RL_EndDrawing();
}

RL_UnloadRenderTexture( $TARGET );

RL_CloseWindow();

//EOF
