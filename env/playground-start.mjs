import { spawn } from 'node:child_process';
import { existsSync, readdirSync, readFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const cwd = process.cwd();
const scriptDir = dirname( fileURLToPath( import.meta.url ) );
const wpEnv = JSON.parse( readFileSync( join( cwd, '.wp-env.json' ), 'utf8' ) );
const themeDir = './source/wp-content/themes/wporg-main-2022';
const sourceDir = join( cwd, themeDir, 'src' );

const requiredPaths = [
	'./source/wp-content/mu-plugins/pub',
	'./source/wp-content/mu-plugins/wporg-mu-plugins',
	...wpEnv.plugins,
	...wpEnv.themes,
	...readdirSync( sourceDir, { withFileTypes: true } )
		.filter( ( entry ) => entry.isDirectory() )
		.filter( ( entry ) => existsSync( join( sourceDir, entry.name, 'index.php' ) ) )
		.map( ( entry ) => `${ themeDir }/build/${ entry.name }/block.json` ),
	`${ themeDir }/build/rosetta/style-index.css`,
	`${ themeDir }/build/style/style-index.css`,
].map( ( path ) => path.replace( /^\.\//, './' ) );

const missingPaths = requiredPaths.filter( ( path ) => ! existsSync( join( cwd, path ) ) );

if ( missingPaths.length ) {
	console.error(
		[
			'Cannot start WordPress Playground because required local dependencies are missing.',
			'',
			'Run the project dependency setup first:',
			'  yarn',
			'  composer install',
			'  yarn setup:tools',
			'  yarn build:theme',
			'',
			'Missing paths:',
			...missingPaths.map( ( path ) => `  - ${ path }` ),
		].join( '\n' )
	);
	process.exit( 1 );
}

const mountIfExists = ( hostPath, runtimePath, args ) => {
	if ( existsSync( join( cwd, hostPath ) ) ) {
		args.push( `--mount=${ hostPath }:${ runtimePath }` );
		return true;
	}

	return false;
};

const args = [
	'@wp-playground/cli',
	'start',
	'--noAutoMount',
];

Object.entries( wpEnv.mappings ).forEach( ( [ runtimePath, hostPath ] ) => {
	mountIfExists( hostPath, `/wordpress/${ runtimePath }`, args );
} );
mountIfExists( './source/wp-content/plugins', '/wordpress/wp-content/plugins', args );
mountIfExists( './source/wp-content/themes', '/wordpress/wp-content/themes', args );

args.push(
	`--blueprint=${ join( scriptDir, '../blueprint.json' ) }`,
	...process.argv.slice( 2 )
);

const child = spawn( 'npx', args, {
	cwd,
	stdio: 'inherit',
} );

child.on( 'exit', ( code, signal ) => {
	if ( signal ) {
		process.kill( process.pid, signal );
		return;
	}

	process.exit( code ?? 1 );
} );
