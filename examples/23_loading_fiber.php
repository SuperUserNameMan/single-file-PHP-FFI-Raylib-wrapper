<?php
//TAB=4

/*
	XXX NOTE : This example is based on 'core_loading_thread.c' example.

	In this version we use a Fiber instead of a thread because there is no native PHP support for threads yet.
	( the `pthreads` extension is abandonned and replaced by the `parallel` extension which is not native neither,
	and for which no PHP8 precompiled DLL seems readily available for download ).

	Fibers all work in the main thread.
	Fibers allow PHP to switch between the main task and a Fiber task.
	Unlike threads, Fibers have to suspend themselves sometimes to share their execution time with the main code, and
	the main code has to resume the execution of the Fibers to share its execution time with them.
*/


include("./raylib/raylib.ffi.php");


$DATA_LOADED = false ;

$DATA_PROGRESS = 0 ;

$LOAD_DATA_FIBER_FUNCTION = function() use ( &$DATA_PROGRESS , &$DATA_LOADED ) : void
{
	$TIME_COUNTER = 0.0 ; // in seconds
	$PREV_TIME    = microtime( true ); // in seconds as float

	// We simulate data loading with a time counter for 5 seconds
	while ( $TIME_COUNTER < 5.0 )
	{
		$TIME_COUNTER = microtime( true ) - $PREV_TIME ;

		// We accumulate time over a global variable to be used in
		// main code as a progress bar
		$DATA_PROGRESS = $TIME_COUNTER * 100.0 ;

		Fiber::suspend();
	}

	$DATA_LOADED = true ;
};

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - loading fiber" );

$FIBER = new Fiber( $LOAD_DATA_FIBER_FUNCTION );

enum  STATE
{
	case WAITING ;
	case LOADING ;
	case FINISHED ;
}

$STATE = STATE::WAITING ;

$FRAMES_COUNTER = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	switch( $STATE )
	{
		case STATE::WAITING:
		{
			if ( RL_IsKeyPressed( RL_KEY_ENTER ) )
			{
				$FIBER->start();
				RL_TraceLog( RL_LOG_INFO , "Loading fiber initialized successfully" );

				$STATE = STATE::LOADING ;
			}
		}
		break;

		case STATE::LOADING:
		{
			$FRAMES_COUNTER++ ;

			$FIBER->resume() ;

			if ( $DATA_LOADED )
			{
				$FRAMES_COUNTER = 0 ;
				RL_TraceLog( RL_LOG_INFO , "Loading fiber terminated successfully" );

				$STATE = STATE::FINISHED ;
			}
		}
		break;

		case STATE::FINISHED:
		{
			if ( RL_IsKeyPressed( RL_KEY_ENTER ) )
			{
				// Reset everything to launch again
				$DATA_LOADED = false ;
				$DATA_PROGRESS = 0 ;
				$STATE = STATE::WAITING ;
				$FIBER = new Fiber( $LOAD_DATA_FIBER_FUNCTION );
			}
		}
		break;

		default: break;
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		switch( $STATE )
		{
			case STATE::WAITING :
				RL_DrawText( "PRESS ENTER to START LOADING DATA" , 150 , 170 , 20 , RL_DARKGRAY );
			break;

			case STATE::LOADING :
			{
				RL_DrawRectangle( 150 , 200 , (int)$DATA_PROGRESS , 60 , RL_SKYBLUE );
				if ( (int)( $FRAMES_COUNTER / 15 ) % 2 )
				{
					RL_DrawText( "LOADING DATA..." , 240 , 210 , 40 , RL_DARKBLUE );
				}
			}
			break;

			case STATE::FINISHED :
			{
				RL_DrawRectangle( 150 , 200 , 500 , 60 , RL_LIME );
				RL_DrawText( "DATA LOADED!" , 250 , 210 , 40 , RL_GREEN );
			}
			break;

			default: break;
		}

		RL_DrawRectangleLines( 150 , 200 , 500 , 60 , RL_DARKGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();


//EOF
