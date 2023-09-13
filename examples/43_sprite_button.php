<?php
//TAB=4

include('./raylib/raylib.ffi.php');

define( 'NUM_FRAMES' , 3 );

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - sprite button" );

RL_InitAudioDevice();

$SOUND  = RL_LoadSound  ( './raylib/examples/resources/blip.wav'  ) ;
$BUTTON = RL_LoadTexture( './raylib/examples/resources/button.png' );

$FRAME_HEIGHT = $BUTTON->height / NUM_FRAMES ;
$SOURCE_RECT  = RL_Rectangle( 0 , 0 , $BUTTON->width , $FRAME_HEIGHT );

$BTN_BOUNDS = RL_Rectangle( $SCREEN_W/2.0 - $BUTTON->width/2.0 , $SCREEN_H/2.0 - $BUTTON->height/NUM_FRAMES/2.0 , $BUTTON->width , $FRAME_HEIGHT );

enum STATE : int
{
	case NORMAL  = 0 ;
	case HOVERED = 1 ;
	case PRESSED = 2 ;
}

$BTN_STATE  = STATE::NORMAL ;
$BTN_ACTION = false ;

$MOUSE_POINT = RL_Vector2( 0.0 , 0.0 );

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$MOUSE_POINT = RL_GetMousePosition();
	$BTN_ACTION  = false ;

	if ( RL_CheckCollisionPointRec( $MOUSE_POINT , $BTN_BOUNDS ) )
	{
		$BTN_STATE = ( RL_IsMouseButtonDown( RL_MOUSE_BUTTON_LEFT ) ) ? STATE::PRESSED : STATE::HOVERED ;

		if ( RL_IsMouseButtonReleased( RL_MOUSE_BUTTON_LEFT) ) $BTN_ACTION = true ;
	}
	else $BTN_STATE = STATE::NORMAL;

	if ( $BTN_ACTION )
	{
		RL_PlaySound( $SOUND );
	}

	// Calculate button frame rectangle to draw depending on button state
	$SOURCE_RECT->y = $BTN_STATE->value * $FRAME_HEIGHT ;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawTextureRec( $BUTTON , $SOURCE_RECT , RL_Vector2( $BTN_BOUNDS->x , $BTN_BOUNDS->y ) , RL_WHITE );

	RL_EndDrawing();
}

RL_UnloadTexture( $BUTTON );
RL_UnloadSound  ( $SOUND  );

RL_CloseAudioDevice();

RL_CloseWindow();

//EOF
