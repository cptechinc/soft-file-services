<?php include('./_head.php'); ?>
	<main role="main">
		<div class="jumbotron bg-dark text-light">
			<div class="container">
				<h1 class="display-3"><?= $page->get('pagetitle|headline|title') ; ?></h1>
			</div>
		</div>
		<div class="container page">
            
        <div class="card">
            <div class="row">
                <div class="col-1 d-flex justify-content-center align-items-center bg-primary text-white">
                    <i class="fa fa-2x fa-exclamation-triangle" aria-hidden="true"></i>
                </div>
                <div class="col-11 alert-info">
                    <h5>Error!</h5>
                    <p>Warning, your formatter could not be saved</p>
                    <button type="button" aria-hidden="true" class="close" data-notify="dismiss" style="position: absolute; right: 20px; top: 5px; z-index: 9002;">×</button>
                </div>
            </div>
            <div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="120" aria-valuemin="0" aria-valuemax="100" style="width: 120%;"></div></div>
		</div>
        
	</main>
<?php include('./_foot.php'); // include footer markup ?>
