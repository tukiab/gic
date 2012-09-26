var Lists = {
	load_list: function(list_id){
		$.post('../Common/php/Tasks/_AJAX_lists.php',
				{action: 'load', list_id: list_id},
				function(data){

					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
					else{
						Common.set_content(json.html);
						//list name in the view
						$('#title-tasks').html(json.list_name);
						//mark list as "selected"
						$('a.selected').removeClass('selected').addClass('select');
						$('#select-list-'+ json.list_id).addClass('selected');
						Lists.loaded_list = json.list_id;
						Common.default_operations();
					}
				});
	},
	load_lists: function(){
		$.post('../Common/php/Tasks/_AJAX_lists.php',
				{action: 'load_lists'},
				function(data){
					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
					else{
						$('#lists').html(json.html);
						Common.default_operations();
					}
				});
	},
	load_today: function(){
		$.post('../Common/php/Tasks/_AJAX_lists.php',
				{action: 'load_today'},
				function(data){
					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
					else{
						$('#title-tasks').html('today');
						Common.set_content(json.html);
						Common.default_operations();
					}
				});
	},
	create: function(){
		var name = $('#list-name').val();

		$.post('../Common/php/Tasks/_AJAX_lists.php',
				{action: 'create_list', 'list-name': name}, function(data){
					var json = $.parseJSON(data);
					if(json.error){
						Common.msg(json.error);
					}else{
						Lists.load_lists();
					}
				});
	},

	remove: function(list_id){

		$.post('../Common/php/Tasks/_AJAX_lists.php',
				{action: 'remove_list', list_id: list_id},
				function(data){

					var json = $.parseJSON(data);
					if(json.error)
						Common.msg(json.error);
					else{
						$('#list-'+list_id).remove();
					}
				});
	},

	save_list_name: function(list_id, name){
		$.post('../Common/php/Tasks/_AJAX_lists.php',
				{action: 'update_list', list_id: list_id, 'list-name': name});
	}
};