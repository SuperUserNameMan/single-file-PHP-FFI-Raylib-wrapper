<?php
//TAB=4


include('./raylib/raylib.ffi.php');

$SCREEN_W = 800 ;
$SCREEN_H = 450 ;

RL_InitWindow( $SCREEN_W , $SCREEN_H , "raylib [core] example - generate random values" );

// RL_SetRandomSeed( 0xaabbccff );   // Set a custom random seed if desired, by default: "time(NULL)"

$RAND_VALUE = RL_GetRandomValue( -8 , 5 ); // Get a random integer number between -8 and 5 (both included)

$FRAMES_COUNTER = 0 ;

RL_SetTargetFPS( 60 );

while( ! RL_WindowShouldClose() )
{
	$FRAMES_COUNTER++ ;

	// Every two seconds (120 frames) a new random value is generated
	if ( $FRAMES_COUNTER == 120 )
	{
		$RAND_VALUE = RL_GetRandomValue( -8 , 5 );
		$FRAMES_COUNTER = 0;
	}

	RL_BeginDrawing();

		RL_ClearBackground( RL_RAYWHITE );

		RL_DrawText( "Every 2 seconds a new random value is generated:" , 130 , 100 , 20 , RL_MAROON );

		RL_DrawText( "$RAND_VALUE" , 360 , 180 , 80 , RL_LIGHTGRAY );

	RL_EndDrawing();
}

RL_CloseWindow();

//EOF
