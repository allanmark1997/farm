<template> 
    <!-- <button @click="generatePdf()">Print</button> -->
    <div id="htmlContent">   
        <div class="border-2 border-black" >
            <div class="grid grid-cols-5">
                <div class="col-span-4 p-2">
                    <div class="text-2xl font-bold font-serif">ANI AT KITA</div>
                    <div class="text-3xl font-bold font-serif">RSBSA ENROLLMENT FORM</div>
                    <div class="text-xs">REGISTRY FOR BASIC SECTORS IN AGRICULTURE(RSBSA)</div>
                    <div class="mt-6 flex gap-5 items-center pb-4">
                        <div class="text-xs font-bold">ENROLLMENT:</div>
                        <div class="text-xs" > <CheckTemplate :showCheck="false" label="New"/> </div>
                        <div class="text-xs"><CheckTemplate :showCheck="true" label="Existing"/> </div>
                    </div>
                    <div class="flex gap-1">
                        <div class="text-xs italic">Reference/Control No.:</div>
                        <div class="w-60 border-b border-black"></div>
                    </div>
                </div>
                <div class="border-l-2 border-black flex justify-center">
                    <img v-if="farmers.details.pic2x2" 
                    class="w-[20vmin] max-h-[20vmin] object-contain" 
                    :src="'/images/farmer/' + farmers.details.pic2x2" />
                </div>
            </div>
            <div class="font-bold text-[8px] bg-black text-white pb-2 pl-2">
                PART I: PERSONAL INFORMATION
            </div>
            <div class="">
                <div class="profile">
                    <div class="grid grid-cols-2 gap-6 pb-1">
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[12px] ">{{ farmers?.details.sname || 'NA'}}</div>
                            <div class="text-[9px] font-bold -mt-1">SURNAME</div>
                        </div>  
                        <div class="text-center"> 
                            <div class="border-b border-black pb-1 text-[12px]">{{ farmers?.details.fname || 'NA'}}</div>
                            <div class="text-[9px] font-bold -mt-1">FIRST NAME</div>
                        </div>  
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center pb-2"> 
                            <div class="border-b border-black pb-1 text-[12px] ">{{ farmers?.details.mname || 'NA'}}</div>
                            <div class="text-[9px] font-bold -mt-1">MIDDLE NAME</div>
                        </div> 
                        <div class="flex gap-4 justify-between">
                            <div class="text-center w-[30%] pb-2"> 
                                <div class="border-b border-black pb-1 text-[12px] ">{{ farmers?.details.ename || 'NA' }}</div>
                                <div class="text-[9px] font-bold -mt-1">EXTENSION NAME</div>
                            </div>  
                            <div class="flex gap-4 justify-center border-l-2 border-t-2 border-black w-[60%] mt-3"> 
                                <div class="text-xs font-bold flex items-center">Sex:</div>
                                <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.gender == 'Male'" label="Male"/> </div>
                                <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.gender == 'Female'" label="Female"/></div>
                            </div> 
                        </div> 
                    </div>
                </div> 
                <div class="address border-t-2 border-black">
                    <div class="flex flex-row gap-4 pb-1 pt-2 pr-2">
                        <div class="flex items-center justify-end col-span-[3px] w-[7%]">
                            <div class="text-[10px] font-bold -mt-1">ADDRESS</div>
                        </div>
                        <div class="text-center w-[29%] "> 
                            <div class="border border-black pb-1 text-[10px]">{{ farmers?.details?.lotAddress || 'N/A' }}</div>
                            <div class="text-[9px] font-bold pb-1 -pt-1 -mt-1">HOUSE/LOT/BLDG. NO.</div>
                        </div>  
                        <div class="text-center w-[29%] "> 
                            <div class="border border-black pb-1 text-[10px] ">{{ farmers?.details?.streetAddress || 'N/A'}}</div>
                            <div class="text-[9px] font-bold pb-1 -mt-1">STREET/SITIO/SUBDV</div>
                        </div> 
                        <div class="text-center col-span-2 w-[29%] "> 
                            <div class="border border-black pb-1 text-[10px]">{{ farmers?.details?.baranggayAddress?.name || 'N/A'}}</div>
                            <div class="text-[9px] font-bold pb-1 -mt-1">BARANGGAY</div>
                        </div> 
                    </div>
                    <div class="flex flex-row gap-4 pb-2 pr-2">
                        <div class="w-[7%]"></div>
                        <div class="text-center w-[29%]"> 
                            <div class="border border-black pb-1 text-[10px]">{{ farmers?.details?.cityAddress?.name || 'N/A'}}</div>
                            <div class="text-[9px] font-bold -mt-1">MUNICIPALITY/CITY</div>
                        </div>  
                        <div class="text-center w-[29%]"> 
                            <div class="border border-black pb-1 text-[10px]">{{ farmers?.details?.provinceAddress?.name  || 'N/A'}}</div>
                            <div class="text-[9px] font-bold -mt-1">PROVINCE</div>
                        </div> 
                        <div class="text-center w-[29%]"> 
                            <div class="border border-black pb-1 text-[10px]">{{ farmers?.details?.regionAddress?.name || 'N/A'}}</div>
                            <div class="text-[9px] font-bold -mt-1">REGION</div>
                        </div> 
                    </div>
                </div>
                <div class="border-t-2 border-black">
                    <div class="grid grid-cols-2">
                        <div class="border-r-2 border-black">
                            <div>
                                <div class=" flex items-center gap-2 pl-3 pb-2"> 
                                    <div class="text-[10px] font-bold">CONTACT NUMBER:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.mobile || 'N/A' }}</div>
                                </div> 
                            </div>
                            <div class="flex border-y-2 border-black max-h-16"> 
                                <div  class="border-r-2 border-black w-[35%]">
                                    <div class="text-[11px] font-bold pl-2 pb-1 ">DATE OF BIRTH:</div>
                                    <div class="grid grid-cols-8 border border-black mx-2 text-center">
                                        <div class="border-r border-black pb-1 text-[11px]" v-for="(birth,index) in newBirthDay" :key="index">{{birth}}</div>  
                                    </div>
                                    <div class="grid grid-cols-8 mx-2 text-center pb-1 -mt-1">
                                        <div class="text-[10px]" v-for="(formate,index) in birthFormat" :key="index">{{ formate }}</div> 
                                    </div> 
                                </div>
                                <div class="relative h-14 w-[65%]">
                                    <div class="px-2 relative" >
                                        <div class="text-[11px] font-bold">PLACE OF BIRTH:</div>
                                        <div class="pb-1 text-[.5em] relative">
                                        {{farmers?.details?.lotBirth}}, {{farmers?.details?.streetBirth}},
                                        {{farmers?.details?.baranggayBirth.name}}, {{farmers?.details?.cityBirth?.name}},
                                        {{farmers?.details?.provinceBirth?.name}},{{farmers?.details?.regionBirth?.name}},
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="religionContainer">  
                                <div class=" flex items-center gap-2 pl-3 pb-2 pb-1"> 
                                    <div class="text-[10px] font-bold">RELIGION:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.religion || 'N/A' }}</div>
                                </div> 
                                <div class="grid grid-cols-3 items-center gap-2 pl-3 pb-2"> 
                                    <div class="text-[10px] font-bold">CIVIL STATUS:</div>
                                    <div class="col-span-2">
                                        <div class="grid grid-cols-2"> 
                                            <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.status == 'Single'" label="Single"/> </div>
                                            <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.status == 'Married'" label="Married"/> </div>
                                            <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.status == 'Widowed'" label="Widowed"/> </div>
                                            <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.status == 'Separated'" label="Separated"/> </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-1"> 
                                    <div class="text-[10px] font-bold">NAME OF SPOUSE IF MARRIED:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-2">{{ farmers?.details?.nameSpouse || 'N/A' }}</div>
                                </div>  
                            </div>
                            <div class="motherSection border-t-2 border-black"> 
                                <div class=" flex items-center gap-2 pl-3 pb-2"> 
                                    <div class="text-[10px] font-bold">MOTHER’S MAIDEN NAME:</div>
                                    <div class="text-[14px] grow mr-2">{{ farmers?.details?.motherName || 'N/A' }}</div>
                                </div>  
                            </div>
                            <div class="houseHoldSection">
                                <div class=" pl-2 pt-2 grid grid-cols-4 border-t-2 border-black">
                                    <div class="text-[10px] font-bold col-span-2">HOUSEHOLD HEAD?</div>
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.houseHold == 'Yes'" label="YES"/> </div> 
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.houseHold == 'No'" label="NO"/> </div> 
                                </div>
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-2"> 
                                    <div class="text-[10px] font-bold">If no, name of household head:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.houseHoldName || 'N/A' }}</div>
                                </div>
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-2"> 
                                    <div class="text-[10px] font-bold">Relationship:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.houseHoldRelation || 'N/A' }}</div>
                                </div>
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-1"> 
                                    <div class="text-[10px] font-bold">No. of living household members:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.householdLiving || 'N/A' }}</div>
                                </div>
                                <div class=" flex items-center gap-2 -mt-1"> 
                                    <div class=" flex items-center gap-2 pl-3 pb-2 grow">
                                        <div class="text-[10px] font-bold">No. of male:</div>
                                        <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.householdLiving || 'N/A' }}</div>
                                    </div>
                                    <div class=" flex items-center gap-2 pl-3 pb-2 grow">
                                        <div class="text-[10px] font-bold">No. of female:</div>
                                        <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.householdLiving || 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div>
                            <div class="highestEduc pl-2 border-b-2 border-black pb-2">
                                <div class="text-[10px] font-bold">
                                    HIGHEST FORMAL EDUCATION:
                                </div>
                                <div class="pl-6 grid grid-cols-3">
                                    <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.formalEducational == 'None'" label="None"/> </div>
                                    <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.formalEducational == 'Elementary'" label="Elementary"/> </div>
                                    <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.formalEducational == 'High School'" label="High School"/> </div>
                                    <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.formalEducational == 'Vocational'" label="Vocational"/> </div>
                                    <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.formalEducational == 'College'" label="College"/> </div>
                                    <div class="text-xs "><CheckTemplate :showCheck="farmers?.details.formalEducational == 'Post Graduate'" label="Post Graduate"/> </div> 
                                </div>
                            </div>
                            <div class="">
                                <div class=" pl-2 pt-2 grid grid-cols-4 border-b-2 border-black -mt-1">
                                    <div class="text-[10px] font-bold col-span-2">PERSON WITH DISABILITY (PWD):</div>
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.pwd == 'Yes'" label="YES"/> </div> 
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.pwd == 'No'" label="NO"/> </div> 
                                </div>
                            </div>
                            <div class="4ps border-b-2 border-black">
                                <div class=" pl-2 pt-2 grid grid-cols-4 -mt-1">
                                    <div class="text-[10px] font-bold col-span-2">4P’s Beneficiary?</div>
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.fourPs == 'Yes'" label="YES"/> </div> 
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.fourPs == 'No'" label="NO"/> </div> 
                                </div>
                                <div class=" pl-2 pt-2 grid grid-cols-4 -mt-2">
                                    <div class="text-[10px] font-bold col-span-2">Member of an Indigenous Group?</div>
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.IndigenousGoup == 'Yes'" label="YES"/> </div> 
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.IndigenousGoup == 'No'" label="NO"/> </div> 
                                </div> 
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-1"> 
                                    <div class="text-[10px] font-bold">If yes, specify:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.IndigenousSpecify || 'N/A' }}</div>
                                </div>   
                            </div>
                            <div class="goverment border-b-2 border-black"> 
                                <div class=" pl-2 pt-2 grid grid-cols-4 -mt-1">
                                    <div class="text-[10px] font-bold col-span-2">With Government ID?</div>
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.govermentID == 'Yes'" label="YES"/> </div> 
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.govermentID == 'No'" label="NO"/> </div> 
                                </div> 
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-2"> 
                                    <div class="text-[10px] font-bold">Specify ID number if yes:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.govermentIDSpecify || 'N/A' }}</div>
                                </div>   
                            </div>
                            <div class="goverment border-b-2 border-black"> 
                                <div class=" pl-2 pt-2 grid grid-cols-4">
                                    <div class="text-[10px] font-bold col-span-2">Member of any Farmers Association/Cooperative?</div>
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.govermentID == 'Yes'" label="YES"/> </div> 
                                    <div class="text-xs pb-2"><CheckTemplate :showCheck="farmers?.details.govermentID == 'No'" label="NO"/> </div> 
                                </div> 
                                <div class=" flex items-center gap-2 pl-3 pb-2 -mt-2"> 
                                    <div class="text-[10px] font-bold">If yes, specify:</div>
                                    <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.govermentIDSpecify || 'N/A' }}</div>
                                </div>   
                            </div>
                            <div class=" flex items-center gap-2 pl-3 pb-2 pt-1"> 
                                <div class="text-[11px] font-bold">PERSON TO NOTIFY IN <br/> CASE OF EMERGENCY:</div>
                                <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.emergencyPerson || 'N/A' }}</div>
                            </div> 
                            <div class=" flex items-center gap-2 pl-3 pb-2 -mt-1"> 
                                <div class="text-[11px] font-bold">CONTACT NUMBER:</div>
                                <div class="text-[14px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.emergencyContact || 'N/A' }}</div>
                            </div> 
                        </div>
                    </div> 
                </div> 
                <div class="font-bold text-[8px] bg-black text-white pb-2 pl-2">
                    PART II: FARM PROFILE
                </div>
                <div class="farmNaNila -mt-1">
                    <div class="grid grid-cols-4 gap-1 pb-1 border-t-2 border-black items-center pt-2 -mt-1">
                        <div class="text-center -mt-1"> 
                            <div class="pb-1 text-[11px] font-bold ">MAIN LIVELIHOOD</div>
                        </div>  
                        <div class="text-center -mt-1">  
                            <div class="pb-1 text-[11px] font-bold"><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Farmer'" label="Farmer"/> </div>
                        </div> 
                        <div class="text-center -mt-1"> 
                            <div class="pb-1 text-[11px] font-bold"><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Farmworker'" label="FARMWORKER/LABORER"/></div>
                        </div>  
                        <div class="text-center -mt-1"> 
                            <div class="pb-1 text-[11px] font-bold"><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Fisherfolk'" label="FISHERFOLK"/></div>
                        </div> 
                    </div> 
                    <div class="grid grid-cols-3 gap-1 pb-1 border-y-2 border-black justify-center text-[11px]">
                        <div class="border-r-2 border-black"> 
                            <div class="pb-1 font-bold italic underline text-center text-[10px]">For farmers:</div>
                            <div class=" pl-2 pb-1 font-bold"> Type of Farming Activity </div>
                            <div  class=" pl-2 pb-1 grid grid-flow-row">
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.farmActivity == 'Rice'" label="Rice"/> </div> 
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.farmActivity == 'Corn'" label="Corn"/> </div>
                                <div class="">
                                    <CheckTemplate :showCheck="farmers?.details?.farmActivity == 'Other crops'" label="Other crops"/>
                                    <div class="flex pl-4 ">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Other crops' ? farmers?.details?.farmSpecify : '' }}</div></div>
                                </div> 
                                <div><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Livestock'" label="Livestock"/></div> 
                                    <div class="flex pl-4">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Livestock' ? farmers?.details?.farmSpecify : '' }}</div></div>
                                <div><CheckTemplate :showCheck="farmers?.details?.mianLivelihood == 'Poultry'" label="Poultry"/></div> 
                                    <div class="flex pl-4">please specify: <div class="border-b border-black w-32 pb-1">{{farmers?.details?.farmActivity == 'Poultry' ? farmers?.details?.farmSpecify : '' }}</div></div>
                            </div>
                        </div>  
                        <div class="">  
                            <div class="pb-1 text-center font-bold italic underline text-[10px]">For farmworkers:</div>
                            <div class="pb-1 pl-1 font-bold"> Kind of Work </div>
                            <div  class=" pl-2 pb-1">
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.farmWork == 'Land Preparation'" label="Land Preparation"/> </div> 
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.farmWork == ' Planting/Transplanting'" label=" Planting/Transplanting"/> </div>
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.farmWork == 'Cultivation'" label="Cultivation"/> </div> 
                                <div class=""><CheckTemplate :showCheck="farmers?.details?.farmWork == 'Harvesting'" label="Harvesting"/> </div>
                                <div><CheckTemplate :showCheck="farmers?.details?.farmWork == 'Others'" label="Others"/></div> 
                                    <div class="flex pl-4">please specify: <div class="border-b border-black w-32 pb-1">
                                        {{farmers?.details?.farmWork == 'Others' ? farmers?.details?.farmWorkSpecify : 'N/A' }}</div></div>
                                 
                            </div>
                        </div> 
                        <div class="border-l-2 border-black "> 
                            <div class="pb-1 text-[10px] font-bold italic underline text-center">For fisherfolk:</div>
                            <div  class="pl-2 pb-1 text-[8px] font-bold">
                                The Lending Conduit shall coordinate with the Bureau of Fisheries and Aquatic Resources (BFAR) in the issuance of
                                a certification that the fisherfolk-borrower under PUNLA/ PLEA is registered under the Municipal Fisherfolk Registration (FishR)
                            </div>
                            <div >
                                <div class="pb-1 pl-2 font-bold">Type of Fishing Activity</div>
                                <div class="grid grid-cols-2">
                                    <div class="ml-4">
                                        <div class=""><CheckTemplate :showCheck="farmers?.details?.fishWork == 'Fish Capture'"
                                             label="Fish Capture"/></div>
                                        <div class=""><CheckTemplate :showCheck="farmers?.details?.fishWork == 'Aquaculture'"
                                        label="Aquaculture"/></div>
                                    </div>
                                    <div>
                                        <div class=""><CheckTemplate :showCheck="farmers?.details?.fishWork == 'Fish Processing'"
                                             label="Fish Processing"/></div>
                                        <div class="text-xs"><CheckTemplate :showCheck="farmers?.details?.fishWork == 'Fish Vending'"
                                        label="Fish Vending"/></div>
                                    </div> 
                                </div>
                                <div class="ml-4">
                                    <div class=""><CheckTemplate :showCheck="farmers?.details?.fishWork == 'Gleaning'"
                                            label="Gleaning"/></div>
                                    <div class="t"><CheckTemplate :showCheck="farmers?.details?.fishWork == 'Aquaculture'"
                                    label="Others, please specify:"/></div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="grossAnnual"> 
                    <div class="grid grid-cols-3 gap-2 -mt-1"> 
                        <div class="ml-2 text-[13px] font-bold -mb-1">
                            <div class="">Gross Annual Income Last Year: </div> 
                        </div>
                        <div>
                            <div class=" flex items-center gap-2 pl-3 pb-2 grow">
                                <div class="text-[10px] font-bold">Farming:</div>
                                <div class="text-[12px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.grossFarming || 'N/A' }}</div>
                            </div> 
                        </div>
                        <div>
                            <div class=" flex items-center gap-2 pl-3 pb-2 grow">
                                <div class="text-[10px] font-bold">Non-farming:</div>
                                <div class="text-[12px] border-b border-black grow mr-2 pb-1">{{ farmers?.details?.grossNonFarming || 'N/A' }}</div>
                            </div> 
                        </div> 
                    </div> 
                </div>
            </div> 
        </div>   
        <div class="cutHere border-b border-black h-4 border-dashed mb-4"></div>
        <div class="border-2 border-black">
            <div class="text-center font-bold text-[16px] pb-3">
                <div>Registry System for Basic Sectors in Agriculture (RSBSA)</div>
                <div>ENROLLMENT CLIENT’S COPY</div>
            </div>
            <div class="flex gap-1 ml-2 mb-2">
                <div class="text-xs italic">Reference/Control No.:</div>
                <div class="w-60 border-b border-black"></div>
            </div>
            <div class="grid grid-cols-2 gap-6 pb-1">
                <div class="text-center"> 
                    <div class="border-b border-black pb-1 text-[12px] ">{{ farmers?.details.sname || 'NA'}}</div>
                    <div class="text-[9px] font-bold">SURNAME</div>
                </div>  
                <div class="text-center"> 
                    <div class="border-b border-black pb-1 text-[12px]">{{ farmers?.details.fname || 'NA'}}</div>
                    <div class="text-[9px] font-bold">FIRST NAME</div>
                </div>  
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="text-center pb-2"> 
                    <div class="border-b border-black pb-1 text-[12px] ">{{ farmers?.details.mname || 'NA'}}</div>
                    <div class="text-[9px] font-bold">MIDDLE NAME</div>
                </div> 
                <div class="flex gap-4 justify-between">
                    <div class="text-center w-[30%] pb-2"> 
                        <div class="border-b border-black pb-1 text-[12px] ">{{ farmers?.details.ename || 'NA' }}</div>
                        <div class="text-[9px] font-bold">EXTENSION NAME</div>
                    </div>   
                </div> 
            </div>
        </div>
        <div class="text-center font-bold text-[12px] mt-2 mb-4">THIS FORM IS NOT FOR SALE</div>
        <br/> 
        <div  v-if="arrangeParcels"> 
            <Parcel v-for="(parcel,index) in arrangeParcels" :key="index" :parcel="parcel"/>  
        </div>
    </div>
</template>
<script setup>
import html2pdf from "html2pdf.js";
import CheckTemplate from "@/Components/Check.vue";
import Parcel from "./Parcel.vue";
import { ref, onMounted } from "vue"; 
 const props = defineProps({
    farmers: {
        type:Object,
        default: {},
    },
    parcels: {
        type:Object,
        default: {},
    },
 });

const newBirthDay = ref([]); 
const birthFormat = ref("MMDDYYYY"); 
const arrangeParcels = ref([]);

const arrangeBday  = ()=>{
    const date = props.farmers?.details?.dateBirth;
    const [year, month, day] = date.split("-");
    const newDate = `${month}${day}${year}`;
    newBirthDay.value =  newDate; 
}
const arrngeFiveSet = (farmList = [])=>{  
    /** Divisible by 5 then fill with {object empty} to complete the remainder */
    let i = Math.floor(farmList.length % 5);
    if(farmList.length != 5){
        while(i < 5 ){
            farmList.push({}); 
            i++;
        }
    }
    return farmList;
}
const arrangeParcel = ()=>{ 
    /** Divisible by 3 then fill with {object empty} to complete the remainder */
    const setGroup  = Math.floor(props.parcels.length % 3);
    let i = setGroup;
    if(props.parcels.length != 3){
        while(i < 3 ){
            props.parcels.push({});
            console.log(props.parcels.length); 
            console.log("timer this one")
            i++;
        }
    } 
    /**  group by 3 and arrange data */
    const groupLength = 3;
    arrangeParcels.value = props.parcels.reduce((acc,item,index)=>{
        const groupParcel = Math.floor(index / groupLength);
        if(!acc[groupParcel]){ acc[groupParcel] = [];}
        acc[groupParcel].push({...item,crops:arrngeFiveSet(item.farms),sizes:arrngeFiveSet(item.farms),
            noOfHeads:arrngeFiveSet(item.farms),farmTypes:arrngeFiveSet(item.farms),organics:arrngeFiveSet(item.farms)});
        return acc;
    },[]);
    console.log(arrangeParcels.value); 
}

onMounted(()=>{ 
    console.log(props.parcels);
    arrangeBday();
    arrangeParcel();
    
})

 const generatePdf = () => {
        html2pdf(document.getElementById("htmlContent"), {
            margin: 5,
            filename: "Form", 
            jsPDF:{ format: 'legal',}
        });
}
defineExpose({generatePdf})

</script>
