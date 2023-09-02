<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_SetConfigFlags( RL_FLAG_WINDOW_RESIZABLE | RL_FLAG_VSYNC_HINT );
RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - window scale letterbox" );
RL_SetWindowMinSize( 320 , 240 );

$GAME_SCREEN_W = 640 ;
$GAME_SCREEN_H = 480 ;

// Render texture initialization, used to hold the rendering result so we can easily resize it
$TARGET = RL_LoadRenderTexture( $GAME_SCREEN_W , $GAME_SCREEN_H );
RL_SetTextureFilter( $TARGET->texture , RL_TEXTURE_FILTER_BILINEAR );

$COLORS = [];
for ( $i = 0 ; $i < 10 ; $i++ )
{
	$COLORS[ $i ] = RL_Color
	(
		RL_GetRandomValue( 100 , 250 ) ,
		RL_GetRandomValue(  50 , 150 ) ,
		RL_GetRandomValue(  10 , 100 ) ,
		255
	);
}

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$SCALE = min( (float)RL_GetScreenWidth() / $GAME_SCREEN_W , (float)RL_GetScreenHeight() / $GAME_SCREEN_H );

	if ( RL_IsKeyPressed( RL_KEY_SPACE ) )
	{
		// Recalculate random colors for the bars
		for ( $i = 0 ; $i < 10 ; $i++ )
		$COLORS[ $i ] = RL_Color
		(
			RL_GetRandomValue( 100 , 250 ) ,
			RL_GetRandomValue(  50 , 150 ) ,
			RL_GetRandomValue(  10 , 100 ) ,
			255
		);
	}

	// Update virtual mouse (clamped mouse value behind game screen)
	$MOUSE         = RL_GetMousePosition();
	$VIRTUAL_MOUSE = RL_Vector2();
	$VIRTUAL_MOUSE->x = ( $MOUSE->x - ( RL_GetScreenWidth()  - ( $GAME_SCREEN_W * $SCALE ) )*0.5 ) / $SCALE ;
	$VIRTUAL_MOUSE->y = ( $MOUSE->y - ( RL_GetScreenHeight() - ( $GAME_SCREEN_H * $SCALE ) )*0.5 ) / $SCALE ;
	$VIRTUAL_MOUSE = RL_Vector2Clamp( $VIRTUAL_MOUSE , RL_Vector2( 0 , 0 ) , RL_Vector2( $GAME_SCREEN_W , $GAME_SCREEN_H ) );

	// Apply the same transformation as the virtual mouse to the real mouse (i.e. to work with raygui)
	//RL_SetMouseOffset( -( RL_GetScreenWidth() - ( $GAME_SCREEN_W * $SCALE ) )*0.5 , -( RL_GetScreenHeight() - ( $GAME_SCREEN_H * $SCALE ) )*0.5 );
	//RL_SetMouseScale( 1.0 / $SCALE , 1.0 / $SCALE );

	// Draw everything in the render texture, note this will not be rendered on screen, yet
	RL_BeginTextureMode( $TARGET );

		RL_ClearBackground( RL_RAYWHITE );

		for ( $i = 0 ; $i < 10 ; $i++ )
		{
			RL_DrawRectangle( 0 , ( $GAME_SCREEN_H / 10 ) * $i , $GAME_SCREEN_W , $GAME_SCREEN_H / 10 , $COLORS[$i] );
		}

		RL_DrawText( "If executed inside a window,\nyou can resize the window,\nand see the screen scaling!" , 10 , 25 , 20 , RL_WHITE );
		RL_DrawText( RL_TextFormat( "Default Mouse: [%i , %i]" , (int)$MOUSE->x         , (int)$MOUSE->y         ) , 350 , 25 , 20 , RL_GREEN  );
		RL_DrawText( RL_TextFormat( "Virtual Mouse: [%i , %i]" , (int)$VIRTUAL_MOUSE->x , (int)$VIRTUAL_MOUSE->y ) , 350 , 55 , 20 , RL_YELLOW );

	RL_EndTextureMode();

	RL_BeginDrawing();

		RL_ClearBackground( RL_BLACK );

		// Draw render texture to screen, properly scaled
		RL_DrawTexturePro
		(
			$TARGET->texture ,
			RL_Rectangle( 0.0 , 0.0 , $TARGET->texture->width , -$TARGET->texture->height ) ,
			RL_Rectangle
			(
				( RL_GetScreenWidth()  - ( $GAME_SCREEN_W * $SCALE ) )*0.5 ,
				( RL_GetScreenHeight() - ( $GAME_SCREEN_H * $SCALE ) )*0.5 ,
				$GAME_SCREEN_W * $SCALE ,
				$GAME_SCREEN_H * $SCALE
			) ,
			RL_Vector2( 0, 0 ) ,
			0.0 ,
			RL_WHITE
		);

	RL_EndDrawing();
}

RL_UnloadRenderTexture( $TARGET );

RL_CloseWindow();

//EOF
