<?php
//TAB=4


include('./raylib/raylib.ffi.php');

$SCREEN_W = 1280 ;
$SCREEN_H = 450 ;

// Possible window flags :
/*
RL_FLAG_VSYNC_HINT
RL_FLAG_FULLSCREEN_MODE    -> not working properly -> wrong scaling!
RL_FLAG_WINDOW_RESIZABLE
RL_FLAG_WINDOW_UNDECORATED
RL_FLAG_WINDOW_TRANSPARENT
RL_FLAG_WINDOW_HIDDEN
RL_FLAG_WINDOW_MINIMIZED   -> Not supported on window creation
RL_FLAG_WINDOW_MAXIMIZED   -> Not supported on window creation
RL_FLAG_WINDOW_UNFOCUSED
RL_FLAG_WINDOW_TOPMOST
RL_FLAG_WINDOW_HIGHDPI     -> errors after minimize-resize, fb size is recalculated
RL_FLAG_WINDOW_ALWAYS_RUN
RL_FLAG_MSAA_4X_HINT
*/

$FLAGS = [ // key , const , string
	[ 'F' , RL_FLAG_FULLSCREEN_MODE    , 'FLAG_FULLSCREEN_MODE'    ],
	[ 'R' , RL_FLAG_WINDOW_RESIZABLE   , 'FLAG_WINDOW_RESIZABLE'   ],
	[ 'D' , RL_FLAG_WINDOW_UNDECORATED , 'FLAG_WINDOW_UNDECORATED' ],
	[ 'H' , RL_FLAG_WINDOW_HIDDEN      , 'FLAG_WINDOW_HIDDEN'      ],
	[ 'N' , RL_FLAG_WINDOW_MINIMIZED   , 'FLAG_WINDOW_MINIMIZED'   ],
	[ 'M' , RL_FLAG_WINDOW_MAXIMIZED   , 'FLAG_WINDOW_MAXIMIZED'   ],
	[ 'U' , RL_FLAG_WINDOW_UNFOCUSED   , 'FLAG_WINDOW_UNFOCUSED'   ],
	[ 'T' , RL_FLAG_WINDOW_TOPMOST     , 'FLAG_WINDOW_TOPMOST'     ],
	[ 'A' , RL_FLAG_WINDOW_ALWAYS_RUN  , 'FLAG_WINDOW_ALWAYS_RUN'  ],
	[ 'V' , RL_FLAG_VSYNC_HINT         , 'FLAG_VSYNC_HINT'         ],
];


// Set configuration flags for window creation
//RL_SetConfigFlags( RL_FLAG_VSYNC_HINT | RL_FLAG_MSAA_4X_HINT | RL_FLAG_WINDOW_HIGHDPI );
//RL_SetConfigFlags( RL_FLAG_WINDOW_TRANSPARENT );

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - window flags" );

$BALL_POSITION = RL_Vector2( RL_GetScreenWidth() / 2.0 , RL_GetScreenHeight() / 2.0 );
$BALL_SPEED    = RL_Vector2( 5.0 , 4.0 );
$BALL_RADIUS   = 20 ;
$FRAME_COUNTER = 0 ;

while( ! RL_WindowShouldClose() )
{
	if ( RL_IsKeyPressed( RL_KEY_F ) ) RL_ToggleFullscreen();

	if ( RL_IsKeyPressed( RL_KEY_R ) )
	{
		if ( RL_IsWindowState( RL_FLAG_WINDOW_RESIZABLE ) )
		{
			RL_ClearWindowState( RL_FLAG_WINDOW_RESIZABLE);
		}
		else
		{
			RL_SetWindowState( RL_FLAG_WINDOW_RESIZABLE );
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_D ) )
	{
		if ( RL_IsWindowState( RL_FLAG_WINDOW_UNDECORATED ) )
		{
			RL_ClearWindowState( RL_FLAG_WINDOW_UNDECORATED );
		}
		else
		{
			RL_SetWindowState( RL_FLAG_WINDOW_UNDECORATED );
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_H ) )
	{
		if ( ! RL_IsWindowState( RL_FLAG_WINDOW_HIDDEN ) )
		{
			RL_SetWindowState( RL_FLAG_WINDOW_HIDDEN );
		}

		$FRAME_COUNTER = 0;
	}

	if ( RL_IsWindowState( RL_FLAG_WINDOW_HIDDEN ) )
	{
		$FRAME_COUNTER++ ;
		if ( $FRAME_COUNTER >= 240 ) RL_ClearWindowState( RL_FLAG_WINDOW_HIDDEN );
	}

	if ( RL_IsKeyPressed( RL_KEY_N ) )
	{
		if ( ! RL_IsWindowState( RL_FLAG_WINDOW_MINIMIZED) ) RL_MinimizeWindow();

		$FRAME_COUNTER = 0;
	}

	if ( RL_IsWindowState( RL_FLAG_WINDOW_MINIMIZED ) )
	{
		$FRAME_COUNTER++ ;
		if ( $FRAME_COUNTER >= 240 ) RL_RestoreWindow();
	}

	if ( RL_IsKeyPressed( RL_KEY_M ) )
	{
		// NOTE: Requires FLAG_WINDOW_RESIZABLE enabled!
		if ( RL_IsWindowState( RL_FLAG_WINDOW_MAXIMIZED ) )
		{
			RL_RestoreWindow();
		}
		else
		{
			RL_MaximizeWindow();
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_U ) )
	{
		if ( RL_IsWindowState( RL_FLAG_WINDOW_UNFOCUSED ) )
		{
			RL_ClearWindowState( RL_FLAG_WINDOW_UNFOCUSED );
		}
		else
		{
			RL_SetWindowState( RL_FLAG_WINDOW_UNFOCUSED );
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_T ) )
	{
		if ( RL_IsWindowState( RL_FLAG_WINDOW_TOPMOST ) )
		{
			RL_ClearWindowState( RL_FLAG_WINDOW_TOPMOST );
		}
		else
		{
			RL_SetWindowState( RL_FLAG_WINDOW_TOPMOST );
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_A ) )
	{
		if ( RL_IsWindowState( RL_FLAG_WINDOW_ALWAYS_RUN ) )
		{
			RL_ClearWindowState( RL_FLAG_WINDOW_ALWAYS_RUN );
		}
		else
		{
			RL_SetWindowState( RL_FLAG_WINDOW_ALWAYS_RUN );
		}
	}

	if ( RL_IsKeyPressed( RL_KEY_V ) )
	{
		if ( RL_IsWindowState( RL_FLAG_VSYNC_HINT ) )
		{
			RL_ClearWindowState( RL_FLAG_VSYNC_HINT );
		}
		else
		{
			RL_SetWindowState( RL_FLAG_VSYNC_HINT );
		}
	}


	$BALL_POSITION->x += $BALL_SPEED->x ;
	$BALL_POSITION->y += $BALL_SPEED->y ;

	if (
		( $BALL_POSITION->x >= ( RL_GetScreenWidth() - $BALL_RADIUS ) )
		||
		( $BALL_POSITION->x <= $BALL_RADIUS )
	){
		$BALL_SPEED->x *= -1.0 ;
	}

	if (
		( $BALL_POSITION->y >= ( RL_GetScreenHeight() - $BALL_RADIUS ) )
		||
		( $BALL_POSITION->y <= $BALL_RADIUS )
	){
		$BALL_SPEED->y *= -1.0 ;
	}

	$BALL_POSITION->x = max( $BALL_RADIUS , min( $BALL_POSITION->x , RL_GetScreenWidth() - $BALL_RADIUS ));
	$BALL_POSITION->y = max( $BALL_RADIUS , min( $BALL_POSITION->y , RL_GetScreenHeight() - $BALL_RADIUS ));

	RL_BeginDrawing();

		if ( RL_IsWindowState( RL_FLAG_WINDOW_TRANSPARENT ) )
		{
			RL_ClearBackground( RL_BLANK );
		}
		else
		{
			RL_ClearBackground( RL_RAYWHITE );
		}

		RL_DrawCircleV( $BALL_POSITION , $BALL_RADIUS , RL_MAROON );
		RL_DrawRectangleLinesEx( RL_Rectangle( 0 , 0 , RL_GetScreenWidth() , RL_GetScreenHeight() ) , 4 , RL_RAYWHITE );

		RL_DrawCircleV( RL_GetMousePosition() , 10 , RL_DARKBLUE );

		RL_DrawFPS( 10 , 10 );

		RL_DrawText( RL_TextFormat( "Screen Size: [%i, %i]" , RL_GetScreenWidth() , RL_GetScreenHeight() ) , 10 , 40 , 10 , RL_GREEN );

		RL_DrawText( "Following flags can be set after window creation:" , 10 , 60 , 10 , RL_GRAY );

		$Y = 80 ;

		foreach( $FLAGS as $FLAG )
		{
			list( $KEY , $FLAG , $TEXT ) = $FLAG ;

			$STATE = RL_IsWindowState( $FLAG );
			$ONOFF = $STATE ? 'on' : 'off' ;
			$COLOR = $STATE ? RL_LIME : RL_MAROON ;

			RL_DrawText( "[$KEY] $TEXT: $ONOFF" , 10 , $Y , 10 , $COLOR );

			$Y += 20 ;
		}

		RL_DrawText( "Following flags can only be set before window creation:" , 10 , 300 , 10 , RL_GRAY );

		if ( RL_IsWindowState( RL_FLAG_WINDOW_HIGHDPI ) )
		{
			RL_DrawText( "FLAG_WINDOW_HIGHDPI: on" , 10 , 320 , 10 , RL_LIME );
		}
		else
		{
			RL_DrawText( "FLAG_WINDOW_HIGHDPI: off" , 10 , 320 , 10 , RL_MAROON );
		}

		if ( RL_IsWindowState( RL_FLAG_WINDOW_TRANSPARENT ) )
		{
			RL_DrawText( "FLAG_WINDOW_TRANSPARENT: on" , 10 , 340 , 10 , RL_LIME );
		}
		else
		{
			RL_DrawText( "FLAG_WINDOW_TRANSPARENT: off" , 10 , 340 , 10 , RL_MAROON );
		}

		if ( RL_IsWindowState( RL_FLAG_MSAA_4X_HINT ) )
		{
			RL_DrawText( "FLAG_MSAA_4X_HINT: on" , 10 , 360 , 10 , RL_LIME );
		}
		else
		{
			RL_DrawText( "FLAG_MSAA_4X_HINT: off" , 10 , 360 , 10 , RL_MAROON );
		}

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
