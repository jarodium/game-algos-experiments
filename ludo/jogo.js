class GAME extends EventEmitter {
    #event;
    #diceValue;

    constructor(options) {
        super();

        this.#event = new EventEmitter(); 
        this.#diceValue = 0;

        this.safeZones = [1, 9, 14, 22, 27, 35, 40, 48];
        this.playerOrder = ['r', 'g', 'y', 'b'];        
        this.playerPipsClasses = ["red","green","yellow","blue"];
        this.playerFinalCells = new Map([
            ["r", 51],
            ["g", 12],
            ["y", 25],
            ["b", 38],
        ]);
        this.playerBasesCells = new Map([
            ["r", 1],
            ["g", 14],
            ["y", 27],
            ["b", 40],
        ]);

        this.startPlayerIndex = 0;

        this.tracks = {
            races: new Map(),
            final: new Map(),
        }
        this.playerTrackRaces = 52;
        this.playerTrackFinals = 6;

        for (var i = 1; i <= this.playerTrackRaces; i++) {
            this.tracks.races.set(i,[]);
        }
        for (var i = 1; i <= this.playerTrackFinals; i++) {
            this.tracks.final.set(i,[]);
        }

        if (options.hasOwnProperty("safeZones")) {
            //default safeZones
            this.safeZones = options.safeZones;
        }

        if (options.hasOwnProperty("startPlayer")) {
            this.startPlayerIndex = this.playerOrder.indexOf(options.startPlayer);
        }
        this.currentPlayerIndex = this.startPlayerIndex;

        this.render();
    }        

    getPlayerColor(playerIndex = this.currentPlayerIndex) {
        return this.playerOrder[playerIndex];
    }
    getPlayerPipColor(playerIndex = this.currentPlayerIndex) {
        return this.playerPipsClasses[playerIndex];
    }

    play(diceValue) {
        this.#diceValue = diceValue;

        if (this.#diceValue == 6) {
            if (this.canDeploy()) {
                    //user is allowed to deploy                  
                this.emit('allowedToDeploy',{
                    playerColor : this.getPlayerColor()
                });
                //this.deploy();
            } else {                
                this.canMove();
            }
        } else {
            this.canMove();
        }
    }

    nextPlayer() {
        this.currentPlayerIndex++;
        if (this.currentPlayerIndex == this.playerOrder.length) this.currentPlayerIndex = 0;
        this.renderDice(this.currentPlayerIndex);
    }

    
    findSingleRacingPip() {
        let pipFound = false;
        let pipWhere = [];

        this.tracks.races.forEach((el, key) => {
            if (el.length > 0 && el.indexOf(this.getPlayerColor()) !== -1) {
                pipWhere = [0,key];
                pipFound = true;
                return;
            }                
        });

        if (!pipFound) {
            this.tracks.final.forEach((el, key) => {
                if (el.length > 0 && el.indexOf(this.getPlayerColor()) !== -1) {
                    pipWhere = [1,key];
                    return;
                }                
            });
        }      
        return pipWhere;  
    }

    isCellAboveRedBase(cellNr) {
        return cellNr > this.playerFinalCells.get('r')+1;
    }
    calculateCellAboveRedBase(cellNr) {        
        return  cellNr - (this.playerFinalCells.get('r')+1);
    }

    calculateNextCellRed(currentCell) {
        /**
         * function returns which next cell is to have the pip
         * 
         */
        let nextCell = currentCell + this.#diceValue;
        let checkFinalCells = this.playerFinalCells.get(this.getPlayerColor());

            //if nextCell is above 52 which is the number of the cell that shows pip should make the final run
            
        if (nextCell > checkFinalCells) {
            //check the distance between the currentCell and checkFinalCells
            let distanceToEnd = checkFinalCells - currentCell;

            //subtract diceValue to the distance
            let diceValue = this.#diceValue - distanceToEnd;            

            //diceValue becomes the new cell in the final track
            return [1,diceValue];
        }
            //returns nextCell position
        return [0,nextCell];                    
    }

    calculateNextCell(currentCell) {
        /**
         * function returns which next cell is to have the pip
         * 
         */
        let nextCell = currentCell + this.#diceValue;
        let playerFinalCell = this.playerFinalCells.get(this.getPlayerColor());
        let playerBaseCell = this.playerBasesCells.get(this.getPlayerColor());
 
        //primeiro verificar se a proxima cell é maior que a minha base
        if (nextCell > playerBaseCell && !(currentCell <= playerFinalCell)) {
            //se sim mover
            console.log("nextcell > playerBaseCell");
            if (this.isCellAboveRedBase(nextCell)) {
                console.log("acima da red base");
                nextCell = this.calculateCellAboveRedBase(nextCell);
            }
            return [0,nextCell];
        }
        else {
            //se não
            console.log("nextcell < playerBase Cell");
                //verificar se está a entrar para a faixa verde
            if (nextCell > playerFinalCell) {
                console.log("nextcell entrando na faixa final");            
                //check the distance between the currentCell and playerFinalCell
                let distanceToEnd = playerFinalCell - currentCell;
    
                //subtract diceValue to the distance
                let diceValue = this.#diceValue - distanceToEnd;            
    
                //diceValue becomes the new cell in the final track
                return [1,diceValue];
            } 
            return [0,nextCell];            
        }
                               
    }

    canMove() {
        //check how many pips are racing
        //  if one
        //      automatically move that one
        //  if more than one
        //      ask user which to move ( show pulse animation on every racing pip)    
        //".cell .r, .r.final .token"
        //document.querySelectorAll(".cell .r, .r.final .token:not(.r.final .transparent .token)").length
        let selector = `.cell .${this.getPlayerPipColor()}, .${this.getPlayerPipColor()}.final .token:not(.${this.getPlayerPipColor()}.final .transparent .token)`
        let pipsRacing = document.querySelectorAll(selector).length;            
        
        console.log("pipsRacing",pipsRacing);
        
        if (pipsRacing == 1) {
            
            let whichPip = null;
            let searchForPip = this.findSingleRacingPip();            
            
            if (searchForPip[0] == 0) {
                whichPip = document.querySelector(`.cell.race-${searchForPip[1]} .token.${this.getPlayerPipColor()}`);
            }
            if (searchForPip[0] == 1) {
                whichPip = document.querySelector(`.cell.${this.getPlayerColor()}-f-${searchForPip[1]} .token`);
            }
                           
            this.move(whichPip);
        }
        else if (pipsRacing > 1) {
            let currentPipsLocationsTrackRaces = [];
            let currentPipsLocationsTrackFinal = [];

            this.tracks.races.forEach((el, key) => {
                if (el.length > 0 && el.indexOf(this.getPlayerColor()) !== -1) {
                    currentPipsLocationsTrackRaces.push(key);
                }                
            });


            this.tracks.final.forEach((el, key) => {
                if (el.length > 0 && el.indexOf(this.getPlayerColor()) !== -1) {                    
                    if (key + this.#diceValue <= this.playerTrackFinals) {
                        currentPipsLocationsTrackFinal.push(key);
                    }                    
                }                
            });

            if (currentPipsLocationsTrackRaces.length > 0 || currentPipsLocationsTrackFinal.length > 0) {
                this.emit('allowedToMove',{
                    playerColor : this.getPlayerColor(),
                    playerPipColor: this.getPlayerPipColor(),
                    selectCellsAtTrackRaces : currentPipsLocationsTrackRaces,
                    selectCellsAtTrackFinal : currentPipsLocationsTrackFinal,
                    diceValue: this.#diceValue
                });
            }
        }
        else {
            //this.endPlay();
            //console.log("no pips to move");
            setTimeout(function() {
                this.nextPlayer();
            }.bind(this), 1500);

        }
          
    }

    move(whichPip) {
        //movement
        let pipWillMove = false;

            //get current cell value and type
        let currentCell = Number(whichPip.parentElement.parentElement.getAttribute("title"));            
        let currentCellType = whichPip.parentElement.parentElement.parentElement.classList.contains("final") ? 1 : 0;
            
        //console.log(currentCellType,currentCell);

            //calculate nextmove            
        let calculatedNextMove = [];
        if (this.getPlayerColor() == 'r') {
            calculatedNextMove = this.calculateNextCellRed(currentCell,this.#diceValue);
        }
        else {
            calculatedNextMove = this.calculateNextCell(currentCell,this.#diceValue);
        }

        let nextCellType = calculatedNextMove[0];
        let nextCell = calculatedNextMove[1];

        if (currentCellType == 0) {
            pipWillMove = true;                                        
        }
        else if (currentCellType == 1) { 
            //console.log("check for final track movement",currentCell,diceValue,currentCell + diceValue);

            if (currentCell + this.#diceValue <= this.playerTrackFinals) {
                pipWillMove = true;
            }            
        }
        //console.log("pipWillMove",pipWillMove);

        let movementData = {
            'currentCell' : currentCell,
            'currentCellType' : currentCellType,
            'nextCell' : nextCell,
            'nextCellType': nextCellType
        }
                
        this.renderMovement(pipWillMove, whichPip, movementData);
            //this.endPlay(diceValue);
            //endPlay method
                
            //pass the turn to other player if dice != 6        
    }
    unDeploy(cellNumber,color) {
        //sends back do base
        let pipColor = this.getPlayerPipColor(this.playerOrder.indexOf(color));

        let target = document.querySelector(".cell.race-"+cellNumber+" .inner .token."+pipColor);

        document.querySelector(".base."+color+" .inner").appendChild(target);
    }
    checkOpponentPips(targetCell) {
        //checks the race         
        let cellNumber = Number(targetCell.title);
                    
        this.tracks.races.get(cellNumber).forEach((el, key) => {            
            if (el !== this.getPlayerColor()) {
                this.unDeploy(cellNumber,el);

                this.removeFromTrackRaces(cellNumber,el);
            }            
        });        
    }
    checkisSafeZone(targetCell) {
        //checks the race         
        let cellNumber = Number(targetCell.title);
        return this.safeZones.indexOf(cellNumber) !== -1;
    }
    checkDestination(whichPip,targetCell) {  
        let targetCellParent = targetCell.parentElement;
        let targetCellParentClasses = targetCellParent.classList;

        let goalClass = this.getPlayerColor()+"-f-"+this.playerTrackFinals;
        let hasReachedGoal = false;
        let hasGameEnded = false;
            //check if targetCell is the goal for the player's color
        if (!targetCellParentClasses.contains(goalClass)) {
            //if not                    
                //check if target cell is a race-type cell
                //console.log(Array.from(targetCellParentClasses));
                const match = Array.from(targetCellParentClasses).find(className => {
                    if (className.includes("race-")) {
                        return true;
                    }
                });
                    //if so
                if (match) {
                    console.log("is a cell race");
                    //check if targetCell is a safe-zone
                        //if it is not
                    if (!this.checkisSafeZone(targetCellParent)) {
                        console.log("not safe");
                        
                            //check if opponent pips are there 
                        this.checkOpponentPips(targetCellParent);
                            //if there are oponent pips                        
                                //move opponent pips pip to player's base
                    }
                    else {
                        console.log("safe cell");
                    }
                }                                                                    
        }    
        else {
            //check win condition if target cell is a final one      
            hasReachedGoal = true;
            if (targetCell.querySelectorAll(".token").length == 4) {
                hasGameEnded = true;
                this.emit("gameOver",{
                    playerIndex : this.currentPlayerIndex,
                    playerColor : this.getPlayerColor(),
                    playerPipColor : this.getPlayerPipColor()
                })
            }            
        }    
            //console.log("destination",targetCell,targetCellParent);
            //end turn
        if (this.#diceValue != 6 && !hasReachedGoal && !hasGameEnded)  {
            setTimeout(function() {
                this.nextPlayer();
            }.bind(this), 1500);
        }
    }

    renderMovement(pipWillMove, whichPip, movementData) {
        console.log("render movement");
        if (pipWillMove) {            
            //remove pip from current cell in this.tracks.races map
            
            let targetCell = null;

            if (movementData.currentCellType == 0) {
                //console.log("remove from trackRaces");
                this.removeFromTrackRaces(movementData.currentCell,this.getPlayerColor());

                if (movementData.nextCellType == 0) {
                        //if nextCellType is a regular trackRace cell
                    targetCell = document.querySelector(".race-"+movementData.nextCell+" .inner");
                    this.addToTrackRaces(movementData.nextCell);
                }     
                if (movementData.nextCellType == 1) {                    
                    targetCell = document.querySelector(".cell."+this.getPlayerColor()+"-f-"+movementData.nextCell+" .inner");
                    this.addToTrackFinal(movementData.nextCell);
                }
            }
            if (movementData.currentCellType == 1) {
                this.removeFromTrackFinal(movementData.currentCell,this.getPlayerColor());                
                targetCell = document.querySelector(".cell."+this.getPlayerColor()+"-f-"+movementData.nextCell+" .inner");
                this.addToTrackFinal(movementData.nextCell);
            }
            
            //move pip from current dom to another
            if (targetCell !== null) {
                targetCell.appendChild(whichPip);

                this.checkDestination(whichPip,targetCell);
            }
        }
        else {
            console.log("render pip not moving");
        }
    }

    canDeploy() {
        //verifies if there are pips inside the base   
        return document.querySelectorAll(".base." + this.getPlayerColor() + " .token").length > 0;
    }

    deploy(target) {
        
        //deploys pip to race start position of the player's base            
        document.querySelector(".start-"+this.getPlayerColor()+" .inner").appendChild(target);
        //adds a pipColor to this.tracks.races
        let cellNr = document.querySelector(".start-"+this.getPlayerColor()).getAttribute("title");
        this.addToTrackRaces(Number(cellNr));
    }

    removeFromTrackRaces(cellNr,playerColor) {
        let currentArray = this.tracks.races.get(cellNr);        
        //let playerColor = this.getPlayerColor();        
                            
        if (currentArray.indexOf(playerColor) !== -1) {
            currentArray.splice(currentArray.indexOf(playerColor),1);
        }            

        this.tracks.races.set(cellNr, currentArray);        
        
            //clear variable
        currentArray = [];
    }

    removeFromTrackFinal(cellNr,playerColor) {
        let currentArray = this.tracks.final.get(cellNr);        
        //let playerColor = this.getPlayerColor();        
        
            //remove one only item!
        if (currentArray.indexOf(playerColor) !== -1) {
            currentArray.splice(currentArray.indexOf(playerColor),1);
        }

        this.tracks.final.set(cellNr, currentArray);        
        
            //clear variable
        currentArray = [];
    }

    addToTrackRaces(cellNr) {
        //adds a "color" to the track.races array
        let currentArray = this.tracks.races.get(cellNr);
        currentArray.push(this.getPlayerColor());
        
        this.tracks.races.set(cellNr, currentArray);

            //clear variable
        currentArray = [];
    }

    addToTrackFinal(cellNr) {
        //adds a "color" to the track.final array
        console.log("addtrackfinal",cellNr);
        
        let currentArray = this.tracks.final.get(cellNr);
        currentArray.push(this.getPlayerColor());
        
        this.tracks.final.set(cellNr, currentArray);

            //clear variable
        currentArray = [];
    }

    renderSafeZones() {
        this.safeZones.forEach(x => {
            document.querySelector(".race-" + x).classList.add("safe-zone");
        });
    }

    renderDice(player) {
        this.playerOrder.forEach(el => {
            document.querySelector(".dice").classList.remove("dice-" + el);
        });

        document.querySelector(".dice").classList.add("dice-" + this.playerOrder[player]);
        document.querySelector(".dice .show").classList.remove('show');
        document.querySelector(".dice .face-0").classList.add('show');
    }

    renderOther() {
        document.querySelectorAll(".cell").forEach((el) => el.innerHTML = '<div class="inner"></div>');
    }

    render() {
        this.renderSafeZones();
        this.renderOther();
        this.renderDice(this.startPlayerIndex);
    }
}