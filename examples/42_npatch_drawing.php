<?php
//TAB=4

include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [textures] example - N-patch drawing" );

$NPATCH_TEXTURE = RL_LoadTexture( "./raylib/examples/resources/npatch_windows.png" );

$MOUSE_POSITION = RL_Vector2();
$ORIGIN         = RL_Vector2();

// Position and size of the n-patches
$DST_REC_1 = RL_Rectangle( 480.0 , 160.0 , 32.0 , 32.0  );
$DST_REC_2 = RL_Rectangle( 160.0 , 160.0 , 32.0 , 32.0  );
$DST_REC_H = RL_Rectangle( 160.0 ,  93.0 , 32.0 , 32.0  );
$DST_REC_V = RL_Rectangle(  92.0 , 160.0 , 32.0 , 32.0  );

// A 9-patch (NPATCH_NINE_PATCH) changes its sizes in both axis
$NINE_PATCH_INFO_1 = RL_NPatchInfo( RL_Rectangle( 0.0 ,   0.0 , 64.0 , 64.0 ) , 16 , 40 , 16 , 16 , RL_NPATCH_NINE_PATCH );
$NINE_PATCH_INFO_2 = RL_NPatchInfo( RL_Rectangle( 0.0 , 128.0 , 64.0 , 64.0 ) , 16 , 16 , 16 , 16 , RL_NPATCH_NINE_PATCH );

// A horizontal 3-patch (NPATCH_THREE_PATCH_HORIZONTAL) changes its sizes along the x axis only
$H3_PATCH_INFO     = RL_NPatchInfo( RL_Rectangle( 0.0 ,  64.0 , 64.0 , 64.0 ) , 16 , 16 , 16 , 16 , RL_NPATCH_THREE_PATCH_HORIZONTAL );

// A vertical 3-patch (NPATCH_THREE_PATCH_VERTICAL) changes its sizes along the y axis only
$V3_PATCH_INFO     = RL_NPatchInfo( RL_Rectangle( 0.0 , 192.0 , 64.0 , 64.0 ) ,  6 ,  6 ,  6 ,  6 , RL_NPATCH_THREE_PATCH_VERTICAL );

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$MOUSE_POSITION = RL_GetMousePosition() ;

	// Resize the n-patches based on mouse position
	$DST_REC_1->width  = $MOUSE_POSITION->x - $DST_REC_1->x ;
	$DST_REC_1->height = $MOUSE_POSITION->y - $DST_REC_1->y ;
	$DST_REC_2->width  = $MOUSE_POSITION->x - $DST_REC_2->x ;
	$DST_REC_2->height = $MOUSE_POSITION->y - $DST_REC_2->y ;
	$DST_REC_H->width  = $MOUSE_POSITION->x - $DST_REC_H->x ;
	$DST_REC_V->height = $MOUSE_POSITION->y - $DST_REC_V->y ;

	// Set a minimum width and/or height
	if ( $DST_REC_1->width  <   1.0 ) $DST_REC_1->width  =   1.0 ;
	if ( $DST_REC_1->width  > 300.0 ) $DST_REC_1->width  = 300.0 ;
	if ( $DST_REC_1->height <   1.0 ) $DST_REC_1->height =   1.0 ;

	if ( $DST_REC_2->width  <   1.0 ) $DST_REC_2->width  =   1.0 ;
	if ( $DST_REC_2->width  > 300.0 ) $DST_REC_2->width  = 300.0 ;
	if ( $DST_REC_2->height <   1.0 ) $DST_REC_2->height =   1.0 ;

	if ( $DST_REC_H->width  <   1.0 ) $DST_REC_H->width  =   1.0 ;
	if ( $DST_REC_V->height <   1.0 ) $DST_REC_V->height =   1.0 ;

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawTextureNPatch( $NPATCH_TEXTURE , $NINE_PATCH_INFO_1 , $DST_REC_1 , $ORIGIN , 0.0 , RL_WHITE );
		RL_DrawTextureNPatch( $NPATCH_TEXTURE , $NINE_PATCH_INFO_2 , $DST_REC_2 , $ORIGIN , 0.0 , RL_WHITE );
		RL_DrawTextureNPatch( $NPATCH_TEXTURE , $H3_PATCH_INFO     , $DST_REC_H , $ORIGIN , 0.0 , RL_WHITE );
		RL_DrawTextureNPatch( $NPATCH_TEXTURE , $V3_PATCH_INFO     , $DST_REC_V , $ORIGIN , 0.0 , RL_WHITE );

		RL_DrawRectangleLines( 5 , 88 , 74 , 266 , RL_BLUE );

		RL_DrawTexture( $NPATCH_TEXTURE , 10 , 93 , RL_WHITE );

		RL_DrawText( "TEXTURE" , 15 , 360 , 10 , RL_DARKGRAY );

		RL_DrawText( "Move the mouse to stretch or shrink the n-patches" , 10 , 20 , 20 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_UnloadTexture( $NPATCH_TEXTURE );

RL_CloseWindow();

//EOF
