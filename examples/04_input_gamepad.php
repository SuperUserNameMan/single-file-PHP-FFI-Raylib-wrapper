<?php
//TAB=4

require("./raylib/raylib.ffi.php");


$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_SetConfigFlags( RL_FLAG_MSAA_4X_HINT );  // Set MSAA 4X hint before windows creation

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - gamepad input" );

$TEXTURE_360_PAS = RL_LoadTexture( "./raylib/examples/resources/xbox.png" );

RL_SetTargetFPS( 60 );               // Set our game to run at 60 frames-per-second

$GAMEPAD_ID = 0 ; // which gamepad to display

while ( ! RL_WindowShouldClose() )    // Detect window close button or ESC key
{
	RL_BeginDrawing();

	RL_ClearBackground( RL_RAYWHITE );

	if ( RL_IsKeyPressed( RL_KEY_LEFT  ) && $GAMEPAD_ID > 0 ) $GAMEPAD_ID-- ;
	if ( RL_IsKeyPressed( RL_KEY_RIGHT ) ) $GAMEPAD_ID++ ;

	if ( RL_IsGamepadAvailable( $GAMEPAD_ID ) )
	{
		RL_DrawText( RL_TextFormat( "GP%d: %s" , (int)$GAMEPAD_ID , RL_GetGamepadName( $GAMEPAD_ID ) ) , 10 , 10 , 10 , RL_BLACK );

		if ( true )
		{
			RL_DrawTexture( $TEXTURE_360_PAS , 0 , 0 , RL_DARKGRAY );

			// Draw buttons: xbox home
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_MIDDLE ) ) RL_DrawCircle( 394 , 89 , 19 , RL_RED );

			// Draw buttons: basic
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_MIDDLE_RIGHT    ) ) RL_DrawCircle( 436 , 150 ,  9 , RL_RED    );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_MIDDLE_LEFT     ) ) RL_DrawCircle( 352 , 150 ,  9 , RL_RED    );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_RIGHT_FACE_LEFT ) ) RL_DrawCircle( 501 , 151 , 15 , RL_BLUE   );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_RIGHT_FACE_DOWN ) ) RL_DrawCircle( 536 , 187 , 15 , RL_LIME   );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_RIGHT_FACE_RIGHT) ) RL_DrawCircle( 572 , 151 , 15 , RL_MAROON );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_RIGHT_FACE_UP   ) ) RL_DrawCircle( 536 , 115 , 15 , RL_GOLD   );

			// Draw buttons: d-pad
			RL_DrawRectangle( 317 , 202 , 19 , 71 , RL_BLACK );
			RL_DrawRectangle( 293 , 228 , 69 , 19 , RL_BLACK );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_LEFT_FACE_UP    ) ) RL_DrawRectangle( 317      , 202      , 19 , 26 , RL_RED );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_LEFT_FACE_DOWN  ) ) RL_DrawRectangle( 317      , 202 + 45 , 19 , 26 , RL_RED );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_LEFT_FACE_LEFT  ) ) RL_DrawRectangle( 292      , 228      , 25 , 19 , RL_RED );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_LEFT_FACE_RIGHT ) ) RL_DrawRectangle( 292 + 44 , 228      , 26 , 19 , RL_RED );

			// Draw buttons: left-right back
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_LEFT_TRIGGER_1  ) ) RL_DrawCircle( 259 , 61 , 20 , RL_RED );
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_RIGHT_TRIGGER_1 ) ) RL_DrawCircle( 536 , 61 , 20 , RL_RED );

			// Draw axis: left joystick

			$LEFT_GAMEPAD_COLOR = RL_BLACK ;
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_LEFT_THUMB ) ) $LEFT_GAMEPAD_COLOR = RL_RED;
			RL_DrawCircle( 259 , 152 , 39 , RL_BLACK );
			RL_DrawCircle( 259 , 152 , 34 , RL_LIGHTGRAY );
			RL_DrawCircle( 259 + (int)( RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_LEFT_X ) * 20 ) ,
			               152 + (int)( RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_LEFT_Y ) * 20 ) ,
			               25, $LEFT_GAMEPAD_COLOR );

			// Draw axis: right joystick
			$RIGHT_GAMEPAD_COLOR = RL_BLACK ;
			if ( RL_IsGamepadButtonDown( $GAMEPAD_ID , RL_GAMEPAD_BUTTON_RIGHT_THUMB ) ) $RIGHT_GAMEPAD_COLOR = RL_RED;
			RL_DrawCircle( 461 , 237 , 38 , RL_BLACK );
			RL_DrawCircle( 461 , 237 , 33 , RL_LIGHTGRAY );
			RL_DrawCircle( 461 + (int)( RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_RIGHT_X ) * 20 ) ,
			               237 + (int)( RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_RIGHT_Y ) * 20 ) ,
			               25 , $RIGHT_GAMEPAD_COLOR );

			// Draw axis: left-right triggers
			RL_DrawRectangle( 170 , 30 , 15 , 70 , RL_GRAY );
			RL_DrawRectangle( 604 , 30 , 15 , 70 , RL_GRAY );
			RL_DrawRectangle( 170 , 30 , 15 , (int)( ( ( 1 + RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_LEFT_TRIGGER ) ) / 2 ) * 70 ) , RL_RED );
			RL_DrawRectangle( 604 , 30 , 15 , (int)( ( ( 1 + RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_RIGHT_TRIGGER) ) / 2 ) * 70 ) , RL_RED );

			//RL_DrawText( RL_TextFormat( "Xbox axis LT: %02.02f" , RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_LEFT_TRIGGER  ) ) , 10 , 40 , 10 , RL_BLACK );
			//RL_DrawText( RL_TextFormat( "Xbox axis RT: %02.02f" , RL_GetGamepadAxisMovement( $GAMEPAD_ID , RL_GAMEPAD_AXIS_RIGHT_TRIGGER ) ) , 10 , 60 , 10 , RL_BLACK );
		}

		RL_DrawText( RL_TextFormat( "DETECTED AXIS [%i]:" , RL_GetGamepadAxisCount( 0 ) ) , 10 , 50 , 10 , RL_MAROON );

		for( $i = 0 ; $i < RL_GetGamepadAxisCount( 0 ) ; $i++ )
		{
			RL_DrawText( RL_TextFormat( "AXIS %i: %.02f" , $i , RL_GetGamepadAxisMovement( 0 , $i ) ) , 20 , 70 + 20 * $i , 10 , RL_DARKGRAY );
		}

		if ( RL_GetGamepadButtonPressed() != RL_GAMEPAD_BUTTON_UNKNOWN )
		{
			RL_DrawText( RL_TextFormat( "DETECTED BUTTON: %i" , RL_GetGamepadButtonPressed()) , 10 , 430 , 10 , RL_RED );
		}
		else
		{
			RL_DrawText( "DETECTED BUTTON: NONE" , 10 , 430 , 10 , RL_GRAY );
		}
	}
	else
	{
		RL_DrawText( RL_TextFormat( "GP%d: NOT DETECTED" , $GAMEPAD_ID ) , 10 , 10 , 10 , RL_GRAY );

		RL_DrawTexture( $TEXTURE_360_PAS , 0 , 0 , RL_LIGHTGRAY );
	}

	RL_EndDrawing();
}

RL_UnloadTexture( $TEXTURE_360_PAS );
RL_UnloadTexture( $TEXTURE_PS3_PAD );

RL_CloseWindow();


//EOF
