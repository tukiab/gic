/**
 * Namespace with all the functions relative to tasks
 */
var Tasks = {
	reset_new_task: function(){
		if($('#task-name').val() == ''){
			$('#task-name').val('nueva tarea');
			$('#date').val('');
			$('#description').val('');
		}
	},

	reset_new_list: function(){
		if($('#list-name').val() == ''){
			$('#list-name').val('nueva lista');
		}
	},

	load_task: function(task_id){
		$.post('../Common/php/Tasks/_AJAX_tasks.php', {action: 'load', task_id: task_id}, function(data){
			var json = $.parseJSON(data);
			if(json.error)
				Common.msg(json.error);
			else{
				Common.set_content(json.html);
				Common.default_operations();
			}
		});
	},

	saving_task: function(task_id){
		var name = $('#task-name').val();
		var date = $('#date').val();
		var description = $('#description').val();

		$.post('../Common/php/Tasks/_AJAX_tasks.php',
				{action: 'update', task_id: task_id, 'task-name': name, date: date, description: description},
				function(data){

					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
					else{
						Lists.load_list(json.list_id);
					}
				});
	},

	save_task_name: function(task_id, name){
		$.post('../Common/php/Tasks/_AJAX_tasks.php',
				{action: 'update', task_id: task_id, 'task-name': name});
	},

	mark_task: function(task_id){
		$.post('../Common/php/Tasks/_AJAX_tasks.php',
				{action: 'change_mark', task_id: task_id}, function(data){

					var json = $.parseJSON(data);
					var chk_obj = $('#chk-'+task_id);
					if(json.error){
						Common.msg(json.error);

						if(chk_obj.attr('checked')){
							chk_obj.attr('checked','');
						}else{
							chk_obj.attr('checked','checked');
						}
					}
					else{
						if(chk_obj.attr('checked')){
							chk_obj.next().addClass('ended');
						}else{
							chk_obj.next().removeClass('ended');
						}
					}
				});
	},

	create: function(list_id){
		var name = $('#task-name').val();
		var description = $('#description').val();
		var date = $('#date').val();

		$.post('../Common/php/Tasks/_AJAX_tasks.php',
				{action: 'create', 'task-name': name, description:description, date:date, list_id:list_id}, function(data){
					var json = $.parseJSON(data);
					if(json.error){
						Common.msg(json.error);
					}else{
						Lists.load_list(json.list_id);
					}
				});
	},

	remove: function(task_id){

		$.post('../Common/php/Tasks/_AJAX_tasks.php',
				{action: 'remove', task_id: task_id},
				function(data){

					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
					else{
						Lists.load_list(json.list_id);
					}
				});
	},

	reorder: function(task_id, new_position){
		$.post('../Common/php/Tasks/_AJAX_tasks.php',
				{action: 'reorder', task_id: task_id, new_order: new_position},
				function(data){

					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
				});
	}
};