public function addstudentInfo($form_state)
{

 $this->database->insert('students')->fields(
 array(
        'uid' =>\Drupal::currentUser()->id(),
		'name' => $form_state->getValue('username'),
		'rollno' => $form_state->getValue('rollno')
		)
	)->execute();
	
	$response = new RedirectResponse("/web/add-student-info");
	$response->send();
	return;
	}
}