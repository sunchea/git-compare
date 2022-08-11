<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Кнопки");?><div class="row">
						<div class="col-md-6">
							<h2>Buttons</h2>
							
							<button type="button" class="btn btn-default">Default</button>
							<button type="button" class="btn btn-primary">Primary</button>
							<button type="button" class="btn btn-success">Success</button>
							<button type="button" class="btn btn-info">Info</button>
							
							<button type="button" class="btn btn-warning">Warning</button>
							
							<button type="button" class="btn btn-danger">Danger</button>
							<button type="button" class="btn btn-transparent">Transparent</button>
							<button type="button" class="btn btn-link">Link</button>
							
							<h2 class="spaced">Buttons Disabled</h2>

							<button type="button" class="btn btn-lg btn-primary" disabled="disabled">Primary button</button>
							<button type="button" class="btn btn-default btn-lg" disabled="disabled">Button</button>
						</div>

						<div class="col-md-6">
							<h2>Buttons Sizes</h2>

							<p>
								<button type="button" class="btn btn-primary btn-lg">Large button</button>
								<button type="button" class="btn btn-default btn-lg">Large button</button>
							</p>
							<p>
								<button type="button" class="btn btn-primary">Default button</button>
								<button type="button" class="btn btn-default">Default button</button>
							</p>
							<p>
								<button type="button" class="btn btn-primary btn-sm">Small button</button>
								<button type="button" class="btn btn-default btn-sm">Small button</button>
							</p>
							<p>
								<button type="button" class="btn btn-primary btn-xs">Extra small button</button>
								<button type="button" class="btn btn-default btn-xs">Extra small button</button>
							</p>

						</div>
					</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>