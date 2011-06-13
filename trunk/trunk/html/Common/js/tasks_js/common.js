var Common = {

	default_operations: function(){
		//$('.date').datepicker({altFormat: 'dd/mm/yy'});
		$('.date').calendar();

		/**
		 * Tasks ended
		 */
		$('#tasks-list .check:checked').each(function(){
			$(this).next().addClass('ended');
		});

		/**
		 * Ordering tasks in the lists
		 */
		$('#tasks-list').sortable({
			containment: 'parent',
			items: 'li:not(#new-task)',
			update: function(event, ui){
				var task_id = ui.item.attr('task_id');
				var new_position = ui.item.index();
				var total = $(this).children().length;
				new_position = total-new_position; //Don't plus 1 because we don't count the first element

				Tasks.reorder(task_id, new_position);				
			}
		});
	},

	msg: function(msg){
	 $('#msgs').html(msg).delay(2000).fadeOut(1000, function(){
			$(this).html('');
		});
	},

	set_content: function(html){
		$('#tasks-lists').html(html);
	}
};

$(document).ready(function(){

	Lists.load_lists();
	Lists.load_list();	

	/**
	 * shoow/Hide the tasks-lists app
	 */
	$('#tasks-lists-container').delegate('a.shoow', 'click', function(){
		var cl = '.'+$(this).attr('classe');
		$(this).removeClass('shoow').addClass('hide');
		//$(this).attr('title','hide the app');
		$(cl).show('fast');
	});

	$('#tasks-lists-container').delegate('a.hide', 'click', function(){
		var cl = '.'+$(this).attr('classe');
		$(this).removeClass('hide').addClass('shoow');
		//$(this).attr('title','shoow the app');
		$(cl).hide('fast');
	});

	/**
	 * Checkbox tasks ended
	 */
	$('#tasks-lists').delegate('.check.mark-task', 'click', function(){
		var task_id = $(this).attr('ide');
		Tasks.mark_task(task_id);		
	});

	/**
	 * Input text task-name
	 */
	$('#tasks-lists-container').delegate('#task-name','click', function(){
		if($('#task-name').val() == 'nueva tarea'){
			$('#task-name').val('');
		}
	});
	$('#tasks-lists-container').delegate('#task-name','blur', function(){
		Tasks.reset_new_task();
	});
	Tasks.reset_new_task();

	/**
	 * Input text list-name
	 */
	$('#tasks-lists-container').delegate('#list-name','click', function(){
		if($('#list-name').val() == 'nueva lista'){
			$('#list-name').val('');
		}
	});
	$('#tasks-lists-container').delegate('#list-name','blur', function(){
		Tasks.reset_new_list();
	});
	Tasks.reset_new_list();

	/**
	 * Open (load) the task
	 */
	$('#tasks-lists-container').delegate('.open-task', 'click', function(){
		var task_id = $(this).attr('task_id');
		Tasks.load_task(task_id);
	});

	$('#tasks-lists-container').delegate('.task-title', 'keyup', function(){
		
		var name = $(this).val();
		var task_id = $(this).attr('ide');

		Tasks.save_task_name(task_id, name);
	});

	$('#tasks-lists-container').delegate('.list-title', 'keyup', function(){

		var name = $(this).val();
		var list_id = $(this).attr('ide');

		Lists.save_list_name(list_id, name);
	});

	/**
	 * New Task and new List
	 */
	$('#tasks-lists-container').delegate('#new-task #task-name', 'keyup', function(event){
		if (event.keyCode == '13')
			Tasks.create($(this).attr('list_id'));
	});

	$('#tasks-lists-container').delegate('#new-list #list-name', 'keyup', function(event){
		if (event.keyCode == '13')
			Lists.create($(this).attr('list_id'));
	});

	$('#tasks-lists-container').delegate('a.add', 'click', function(){
		if($(this).hasClass('add-task'))
			Tasks.create($(this).attr('list_id'));
		else if($(this).hasClass('add-list'))
			Lists.create();
	});

	/**
	 * Delete
	 */
	$('#tasks-lists-container').delegate('a.delete', 'click', function(){
		if($(this).attr('task_id')){
			Tasks.remove($(this).attr('task_id'));
		}else
			Lists.remove($(this).attr('list_id'));
	});
	
	Common.default_operations();
});