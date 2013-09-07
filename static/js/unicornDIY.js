	//容错 
	if(!console){
		var console = {
			log:function(){
			}
		}
	}


	var performaceQuery={};
	performaceQuery.tagsRemark=function(id){
		if(!(this instanceof performaceQuery.tagsRemark)){
			return new performaceQuery.tagsRemark(id);
		}
		this.tags=[];
		this.tags=this.init.call(this,$('input[type=checkbox]','#'+id));

	}
	performaceQuery.tagsRemark.prototype={
		init:function(tagsDom,callback){
			var tags=[];
			$.each(tagsDom,function(index,dom){
				var jDom=$(dom);
				var text=jDom.attr('title');
				var isChecked=jDom.prop('checked');
				if(isChecked){
					console.log(text);
					tags.push(text)
				}
			})
			var This=this;
			tagsDom.on('click',function(){
				var isChecked=$(this).prop('checked');
				var text=$(this).attr('title');
				if(isChecked){
					tags.push(text)
				}else{
					var site=$.inArray(text,tags);
					tags.splice(site,1)
				}
			})
			return tags;
		}
	}
	
	performaceQuery.createDialog=function(id,width,height){
		var This=this;
		if(!(this instanceof performaceQuery.createDialog)){
			return new performaceQuery.createDialog(id,width,height)
		}
		id=$('#'+id).length?dialog+(''+Math.random()).replace(/\D/g,''):id
		this.id=id;
		this.contain=this._showDialog.apply(this,arguments);
		
	}
	performaceQuery.createDialog.prototype={
		_mask:undefined,
		_showMask:function(){
			var mask=this._mask;
			//假如遮罩没有创建
			if(!mask){
				mask='<div class="modal-backdrop fade in"></div>';
				mask=$(mask).appendTo($('body')).show();
				this._mask=mask;
			}else{
				mask.show();
			}
		},
		_removeMask:function(){
			var mask=this._mask;
			mask.remove();
		},
		_showDialog:function(id,width,height){
			var args=Array.prototype.slice.call(arguments);
			var myId,myWid,myHei
			myId=args[0];
			myWid=args[1];
			myHei=args[2];

			
			var dialogCode=[
				'<div id="'+myId+'_contain" >',
				'<div class="" id="'+myId+'"></div>',
				'<a  href="#" alt="close" title="close" onclick="return false" class="d-close chart_close"></a>',
				'</div>'
			];
			var dialog=$(dialogCode.join(''));
			dialog.css({
				'position':'fixed',
				'width':myWid+'px',
				'height':myHei+'px',
				'left':'50%',
				'top':'50%',
				'z-index':1099,
				'margin-left':'-'+Math.floor(myWid/2)+'px',
				'margin-top':'-'+Math.floor(myHei/2)+'px',
			})
			var This=this;
			dialog.children('.d-close').on('click',function(){
				$.proxy(This._hideDialog,This)(dialog)
			})
			dialog.appendTo($('body'));

			This._showMask();
			
			return dialog.children('#'+myId);
		},
		_hideDialog:function(dialog){
			dialog.remove();
			this._removeMask();
			var This=this;
			for(var i in This){
				delete This[i];
			}


		}
	}

	performaceQuery.getData=function(dataSource,dataType){
		if(this._dataFormatMethod.hasOwnProperty(dataType)){
			var myData=this._dataFormatMethod[dataType](dataSource);
			return myData;
		}else{
			return false;
		}
	}
	performaceQuery._dataFormatMethod={
		DOMTABLE:function(dataSource){
				var series=[];
				dataSource=$(dataSource);
				if(dataSource.constructor==$ && dataSource[0] && dataSource[0].tagName.toLowerCase()=='table'){
					$("tr",dataSource).each(function(i,trVal){
						
						var jTr=$(trVal);
						$("td,th",jTr).each(function(j,tdVal){
							var jTd=$(tdVal);
							if(j>0){//第一列是X轴的刻度 不读取
								if (i==0) {//第一行是title 对应的数据不存在 执行创建 第二行之后 执行插入
									var seiresItem={
										name:jTd.text(),
										data:[]
									}
									series[j-1]=seiresItem;
								}else{	

									series[j-1].data.push(parseInt($.trim(jTd.text())))
								}

							}
						})

					})
				}else{
					alert('请先点击查询,以生成数据源');
				}
				return series;
			},
			JSONSTRING:function(){
				var series=[];
				return series;
			}
	}

	performaceQuery.dataCut=function(data,cuts){
		if($.type(data)!='array' || !data.length){
			return false;
		}
		if($.type(cuts)!='array' || !cuts.length){
			return data;
		}
		var cutedData=[];

		//过滤 判断datasource的name 是否存在于判断条件
		data=$.grep(data,function(val,index){
			return $.inArray(val.name,cuts)!==-1;
		})
		return cutedData.concat(data);
	}

	performaceQuery.getXAxis=function(dataSource,dataType){
		if(this._xAxisFormatMethod.hasOwnProperty(dataType)){
			var xAxis=this._xAxisFormatMethod[dataType](dataSource);
			return xAxis;
		}
		return false;
	}
	performaceQuery._xAxisFormatMethod={
		DOMTABLE:function(dataSource){
			var xAxis=[];
			if(dataSource.constructor==$ && dataSource[0] && dataSource[0].tagName.toLowerCase()=='table'){
				$("tr",dataSource).each(function(i,trVal){
					var jTr=$(trVal);
					$("td,th",jTr).each(function(j,tdVal){
						var jTd=$(tdVal);
						if (j==0) {//X轴刻度从table的第一列读取
							if(i>0){//刻度从第二行开始读取
								var strTime=$.trim(jTd.text());
								xAxis.push(strTime)
							}
						};
					})
				})
			}else{
				alert('作为数据源的table不存在')
			}
				return xAxis;
		},
		JSONSTRING:function(){

		}
	}

	performaceQuery.createCharts=function(option){
		var defaultOption={
			contain:'',
			width:100,
			height:400,
			series:[],
			xAxis:[],
			themeName:'line',//Default Grid Gray DarkBlue DarkGreen
			title:'',
			subTitle:'',
			timeline:'',//是否添加时间节制点
			yAxis:{
				title:{
					text: '  '
				}
			}
		}

		option=$.extend(defaultOption,option);
		var series=option.series;
		var xAxis=option.xAxis;
		var yAxis=option.yAxis;
		var title=option.title;
		var subTitle=option.subTitle;
		var chartsType=option.chartsType;

		if ($.type(series)!=='array' || !series.length) {
			alert("数据源录入错误");
			return false;
		}

		var contain=option.contain;
		var containWid=option.width;
		var containHei=option.height;
		contain=$.type(contain)=='string'?$('#'+contain):contain;

		
		if(contain.constructor!==$ || !contain[0].tagName || !contain.length){
			alert('请选择正确的charts容器')
			return false;
		}

		var hightChartsThemes=$.extend(true,{},HIGHCHARTSTHEMES);
		var themeName=option.themeName;
		//应用主题
		if(hightChartsThemes.hasOwnProperty(themeName)){
			var hightChartsTheme=Highcharts.setOptions(hightChartsThemes[themeName]);
		}

		var chartsConfig={
			chart:{
				renderTo:contain[0],
				type:chartsType,
				width:containWid,
				height:containHei,
			},
			title:{
				text:title
			},
			subtitle:{
				text:subTitle
			},
			xAxis:{
				categories:xAxis
			},
			yAxis:{
				title: {
                	text: yAxis.title.text
            	},
            },
	        series:series,
		};

		chartsConfig=$.extend(true,performaceQuery.chartsConfig,chartsConfig)
		new Highcharts.Chart(chartsConfig)


	}

	performaceQuery.chartsConfig={
		chart:{
			marginRight:100,
			marginLeft:80,
			resetZoomButton:{
	            position:{
	                x:-30,
	               	y:20
	            }
            }
		},
		yAxis:{
            min:0,
        },
		tooltip: {
	        formatter: function() {
	            var s=this.x+'<br/><b>'+ this.series.name +'</b>: '+ this.y +'';
	            
	            return s;
	        },
	        style:{
	            maxWidth:'200px',
	            borderColor:"#000000"
	        }
	    },
	    legend: {
	        float:true,
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'top',
	        x: -10,
	        y: 30,
	        itemMarginBottom:4,
	        itemMarginTop:4,
	        borderWidth: 1
	    },
	    credits:{
        	text:'',
            href:'http://yunjin.baidu.com'
        }
	}
	performaceQuery.dateFormat=function(dateStr){
		dateStr=(''+dateStr).replace(/\D/g,'');
		var year=dateStr.substr(0,4);
		var month=dateStr.substr(4,2);
		var day=dateStr.substr(6,2);
		return{
			year:year,
			month:month,
			day:day
		}
	}
	performaceQuery.dateSwtich={
		day:{
			number:{
					'01':'01',
					'02':'02',
					'03':'03',
					'04':'04',
					'05':'05',
					'06':'06',
					'07':'07',
					'08':'08',
					'09':'09',
					'10':'10',
					'11':'11',
					'12':'12',
					'13':'13',
					'14':'14',
					'15':'15',
					'16':'16',
					'17':'17',
					'18':'18',
					'19':'19',
					'20':'20',
					'21':'21',
					'22':'22',
					'23':'23',
					'24':'24',
					'25':'25',
					'26':'26',
					'27':'27',
					'28':'28',
					'29':'29',
					'30':'30',
					'31':'31'
			},
			english:{
					'01':'01st',
					'02':'02nd',
					'03':'03rd',
					'04':'04th',
					'05':'05th',
					'06':'06th',
					'07':'07th',
					'08':'08th',
					'09':'09th',
					'10':'10th',
					'11':'11th',
					'12':'12th',
					'13':'13th',
					'14':'14th',
					'15':'15th',
					'16':'16th',
					'17':'17th',
					'18':'18th',
					'19':'19th',
					'20':'20th',
					'21':'21th',
					'22':'22th',
					'23':'23th',
					'24':'24th',
					'25':'25th',
					'26':'26th',
					'27':'27th',
					'28':'28th',
					'29':'29th',
					'30':'30th',
					'31':'31th'
			},
			chinese :{
					'01':'一号',
					'02':'二号',
					'03':'三号',
					'04':'四号',
					'05':'五号',
					'06':'六号',
					'07':'七号',
					'08':'八号',
					'09':'九号',
					'10':'十号',
					'11':'十一号',
					'12':'十二号',
					'13':'十三号',
					'14':'十四号',
					'15':'十五号',
					'16':'十六号',
					'17':'十七号',
					'18':'十八号',
					'19':'十九号',
					'20':'二十号',
					'21':'二十一号',
					'22':'二十二号',
					'23':'二十三号',
					'24':'二十四号',
					'25':'二十五号',
					'26':'二十六号',
					'27':'二十七号',
					'28':'二十八号',
					'29':'二十九号',
					'30':'三十号',
					'31':'三十一号'
			}
		},
		month:{
			number:{
					'01':'01',
					'02':'02',
					'03':'03',
					'04':'04',
					'05':'05',
					'06':'06',
					'07':'07',
					'08':'08',
					'09':'09',
					'10':'10',
					'11':'11',
					'12':'12',
			},
			english:{
					'01':'Jan',
					'02':'Feb',
					'03':'Mar',
					'04':'Apr',
					'05':'May',
					'06':'Jun',
					'07':'Jul',
					'08':'Aug',
					'09':'Sep',
					'10':'Oct',
					'11':'Nov',
					'12':'Dec',
			},
				chinese :{
					'01':'一月',
					'02':'二月',
					'03':'三月',
					'04':'四月',
					'05':'五月',
					'06':'六月',
					'07':'七月',
					'08':'八月',
					'09':'九月',
					'10':'十月',
					'11':'十一月',
					'12':'十二月',
			}
				
		}
	}


	
