<html>
	<?php
		class SimpleClass
		{
			public $rdetsfull= 'COLLEGE';
			public $roomname= 'CSE';
			public $rowd = '5';
			public $cold = '5';
			public $currentpos=array();
			public $maxpos = '25';
			public $spt=3;   // SPECIFY THE NO OF STUDENTS PER TABLE
			public function getd($datss)
			{
				$this->rdetsfull = $datss;
				for($i=0;$i<$this->spt;$i++)
					$this->currentpos[$i]=0;
			}
			public function dispd()
			{
				echo "Test boom = \"$this->rdetsfull \"<br>";
				echo "Room Name = $this->roomname <br>";
				echo "Number of Rows = $this->rowd <br>";
				echo "Number of Columns = $this->cold <br>";
				echo "Current Pos =".$this->currentpos[0]." ".$this->currentpos[1]." ".$this->currentpos[2]." "."<br>";
			}	
			public function procroomd()
			{
				list($this->roomname, $this->rowd, $this->cold) = explode("-",$this->rdetsfull);
				$this->maxpos=$this->rowd*$this->cold;
			}
			public function rname()
			{
				return $this->roomname;	
			}
			public function rrowd()
			{
				return $this->rowd;
			}
			public function rcold()
			{
				return $this->cold;
			}
			public function rallcpos()
			{
				return $this->currentpos;
			}
			public function rcpos($num1)
			{
				return $this->currentpos[$num1];
			}
			public function icpos($num2)
			{
				$this->currentpos[$num2]++;
			}
			public function rmaxpos()
			{
				return $this->maxpos;
			}
			public function rminindex()
			{
				$index = array_search(min($this->currentpos), $this->currentpos);
				return $index;
			}
		}
		$aaa = array();
		function roomdetails($roomf)
		{
			$spt=3;   // SPECIFY THE NO OF STUDENTS PER TABLE
			$rooms = fopen($roomf, "r") or die("Unable to open file");
			while(!feof($rooms))
			{
				$rdets = fgets($rooms);
				$singleroom = explode(",", $rdets);
				for($i=0;$singleroom[$i]!=NULL;$i++)
				{
					//echo $singleroom[$i];
					$aaa[$i]= new SimpleClass();
					$aaa[$i]->getd($singleroom[$i]);
					$aaa[$i]->procroomd();
					$aaa[$i]->dispd();
					echo "__________________<br><br>";
				}
			}
			fclose($rooms);
			
			$studentsub=array();
			$subfile= array('EC0001.txt','CS0002.txt','ME0003.txt');
			echo count($subfile)."<br>";
			for($i=0; $i<count($subfile); $i++)
			{
				echo "File : $subfile[$i] <br>";
				$tempfile[$i] = fopen($subfile[$i], "r") or die("Unable to open file");
				$sdets=fgets($tempfile[$i]);
				echo $sdets."<br>";
				$studentsub[$i]=explode(",",$sdets);
				fclose($tempfile[$i]);
			}
			$seathold=array();
			$flag=0;
			
			
			echo "HEY HOW U? ".$studentsub[0][6]." NICE";
			
			$m=0;
			$a=0;
			$b=0;
			
			for($i=0; $i<count($subfile); $i++)
			{
				$mini= $aaa[$m]->rminindex();
				echo "<br>$mini ";
				
				for($j=0; $j<count($studentsub[$i]);$j++)	
				{
					echo "<br>$m $a $b $mini <br>";
					//$seathold[$m][$a][$b][$mini]="$m$a$b$mini:J=$j <br>";
					$seathold[$m][$a][$b][$mini]= $studentsub[$i][$j];
					$a++;
					$aaa[$m]->icpos($mini);
					if($a>=$aaa[$m]->rrowd())
					{
						$a=0;
						$b++;
					}	
					if($b>=$aaa[$m]->rcold())
					{
						$m++;
						$a=0;
						$b=0;
					}
				}
				$m=0;
				$a=0;
				$b=0;
				
			}
			
			
			$seathold[0][1][1][1]="WOW ";
			$firstc=0;
			//		TABLE AREA
			echo "<br><br><br><br>";
			for($m=0;$singleroom[$m]!=NULL;$m++)
			{
				
				echo "CLASS : ".$aaa[$m]->rname();
				echo "<table border=0 width=1200>";	
					for($i=0;$i<$aaa[$m]->rrowd();$i++)
						{
						  echo "<tr>";
						  for ($j = 0; $j < $aaa[$m]->rcold(); $j++)
						  {
							echo "<td> $i , $j 
							 <table border=1 width=220>
								<tr>";
							
							for($x=0;$x<$spt;$x++)
								echo "<td width=80 height=30>".$seathold[$m][$i][$j][$x]." </td>";
							
							
							echo "</tr>
							 </table>
							 
							 </td>";
						  }
						  echo "
						  </tr>
						  ";
						}
				echo "<tr><td colspan =5>";
				$aaa[$m]->dispd();
				echo"</td></tr></table><br><br>";
			}
		
			fclose($rooms);
		}
	?>
	<body>
		<?php
			$roomdata= "rooms.txt";
			@roomdetails($roomdata); // NOTICE [errors] HANDLED WITH @ SYMBOL
		?>
	</body>
</html>