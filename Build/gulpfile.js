/**
 * gulpfile.js v4
 * 
 * @author Mati Sediqi<mati_01@icloud.com>
 * @description
 * - This gulpfile can be used as a boilerplate to easier kickstart projects.
 * - It includes a cache-bust-system (using timestamp as versioning-identifier),
 * - which can be used for both local and production environments.
 */

/** Gulpfile Helper. */
const GulpfileHelper = require("./gulpfile-helper.js");
let gulpfileHelper = new GulpfileHelper();

/** Compiler object (the node_modules which are required for this gulpfile.js) will be added dynamically if the module exists. */
let compiler = {};

let compilerModules = [
	"gulp",
	"gulp-clean",
	"gulp-concat",
	"gulp-terser-js",
	"gulp-sass",
	"gulp-minify-css",
	"gulp-rev",
	"del"
];

/** Checking if all modules are installed and if not adding those which ain't yet to display the developer which are still required / not found. */
let missingCompilerModules = "";
compilerModules.forEach((compilerModule, index) => {
	if(!gulpfileHelper.moduleExists(compilerModule)) {
		console.log(`The module: ${compilerModule} doesn't exists`);
		// console.log(`Please install this module using yarn add ${compilerModule}`);
		missingCompilerModules += compilerModule + " ";
	}

	if(missingCompilerModules == "") {
		compiler[compilerModule] = require(compilerModule);
	}
});

if(missingCompilerModules != "") {
	missingCompilerModules = missingCompilerModules.replace(/.$/, "");
	console.log("\nPlease install all necessary modules using the following command:");
	console.log(`> yarn add ${missingCompilerModules}\n\n`);
	return false;
}

let gulp = compiler["gulp"];
let sass = compiler["gulp-sass"];
let concat = compiler["gulp-concat"];
let terser = compiler["gulp-terser-js"];
let minify = compiler["gulp-minify-css"];
let rev = compiler["gulp-rev"];
let del = compiler["del"];


// ============================================================================================================
/** Directory-Configuration */
	inputSrc = "Assets/";
	outputSrc = "../public/backend/";
	fileName = "centauri.min";


// ============================================================================================================
/** node_modules */
let modules = [
	"jquery/jquery.min.js",
	"jquery-ui/jquery-ui.min.js",

	"waves/dist/waves.min.js",
	"pickr/dist/pickr.min.js",

	"ckeditor5/build/ckeditor.js",

	"cropperjs/dist/cropper.min.js",
	"jquery-cropper/dist/jquery-cropper.js",

	"jquery-focuspoint/js/jquery.focuspoint.min.js"
];

modules.forEach((_module, index) => {
	modules[index] = "../packages/" + _module;
});

gulp.task("rev:del", () => {
	return del(outputSrc + "rev-manifest.json", {
		force: true
	});
});

// ============================================================================================================
/** CSS Tasks */

gulp.task("css:clean", () => {
	return del([
		outputSrc + "rev/css/*.css",
		outputSrc + "css/*.css"
	], {
		force: true
	});
});

gulp.task("css:build", () => {
	return gulp.src(inputSrc + "scss/main.scss")
		.pipe(sass().on("error", sass.logError))

	.pipe(concat(fileName + ".css"))

	.pipe(minify({
		processImport: true
	}))

	// .pipe(rev())

	.pipe(gulp.dest(outputSrc + "css"))
	// .pipe(rev.manifest("public/backend/rev-manifest.json", {
	// 	base: "public/backend",
	// 	merge: true
	// }))

	.pipe(gulp.dest(outputSrc));
});

gulp.task("css:deploy", () => {
	return gulp.src(inputSrc + "scss/main.scss")
		.pipe(sass().on("error", sass.logError))

	.pipe(concat(fileName + ".css"))

	.pipe(minify({
		processImport: true
	}))

	.pipe(rev())

	.pipe(gulp.dest(outputSrc + "css"))
	.pipe(rev.manifest("public/backend/rev-manifest.json", {
		base: "public/backend",
		merge: true
	}))

	.pipe(gulp.dest(outputSrc));
});

// ============================================================================================================
/** JS Tasks */

gulp.task("js:clean", () => {
	return del([
		outputSrc + "rev/js/*.js",
		outputSrc + "js/*.js"
	], {
		force: true
	});
});

gulp.task("js:build", () => {
	return gulp.src(
        Array.prototype.concat(
            modules,
			inputSrc + "js/**/*.js"
        )
    )

	.pipe(concat(fileName + ".js"))

	// .pipe(rev())

	.pipe(gulp.dest(outputSrc + "js"))
	// .pipe(rev.manifest("public/backend/rev-manifest.json", {
	// 	base: "public/backend",
	// 	merge: true
	// }))

	.pipe(gulp.dest(outputSrc));
});

gulp.task("js:deploy", () => {
	return gulp.src(
        Array.prototype.concat(
            modules,
			inputSrc + "js/**/*.js"
        )
    )
	.pipe(concat(fileName + ".js"))

	.pipe(terser({
		mangle: {
			toplevel: true
		}
	})).on("error", (error) => {
		this.emit("end")
	})

	.pipe(rev())

	.pipe(gulp.dest(outputSrc + "js"))
	.pipe(rev.manifest("public/backend/rev-manifest.json", {
		base: "public/backend",
		merge: true
	}))

	.pipe(gulp.dest(outputSrc));
});
// ============================================================================================================



// ============================================================================================================
// Build with Watcher Task

gulp.task("watch:build:task", () => {
	gulp.series("rev:del");
	gulp.watch(inputSrc + "scss/**/*.{sass,scss}", gulp.series("css:build"));
	gulp.watch(inputSrc + "js/**/*.js", gulp.series("js:build"));
});

gulp.task("watch:build", gulp.series("css:build", "js:build",
	gulp.parallel("rev:del", "watch:build:task")
));

gulp.task("build", gulp.series("rev:del", "css:clean", "css:build", "js:clean", "js:build",
	gulp.parallel("watch:build")
));
// ============================================================================================================



// ============================================================================================================
// Deploy with Watcher Task

gulp.task("watch:deploy:task", () => {
	gulp.watch(inputSrc + "scss/**/*.{sass,scss}", gulp.series("css:clean"), gulp.series("css:deploy"));
	gulp.watch(inputSrc + "js/**/*.js", gulp.series("js:clean"), gulp.series("js:deploy"));
});

gulp.task("watch:deploy", gulp.series("css:deploy", "js:deploy", gulp.parallel("watch:deploy:task")));
gulp.task("watch:deploy", gulp.series("css:deploy", "js:deploy", gulp.parallel("watch:deploy")));
// ============================================================================================================



// ============================================================================================================
// Simple deploy task

gulp.task("deploy", gulp.series("rev:del", "css:clean", "js:clean", "css:deploy", "js:deploy"));
// ============================================================================================================
