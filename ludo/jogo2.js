class Jogador extends EventEmitter {
    #event;

    constructor(options) {
        super();
        this.#event = new EventEmitter();

        for (const chave in options) {
            if (options.hasOwnProperty(chave)) {
                this[chave] = options[chave];
            }
        }
    }
}

class Pipeta {
    constructor(options) {
        this.cor = options.cor;
    }
}

class Dado extends EventEmitter {
    #event;
    constructor(options) {
        super();
        this.#event = new EventEmitter();

        this.cor = options.cor;
    }

    rolar() {
        this.emit('dadoRolado',{
            resultado : droll.roll('1d6')
        });
    }
}

class Casa {

    constructor(options) {
        this.tipo = options.tipo ?? 'normal'; // normal // final // base
        this.segura = options.segura ?? false;
        this.cor = options.cor ?? 't';
        this.pipetas = options.pipetas ?? [];
    }
}

class Tabuleiro extends EventEmitter {
    #event;
    constructor(options) {
        super();
        this.#event = new EventEmitter();

        this.jogadoresCount   = options.jogadores ?? 1;
        this.casaDosJogadores = [
            {cor:'r', classe: 'red',    casaPartida : 1,  casaFinal: 51},
            {cor:'g', classe: 'green',  casaPartida : 14, casaFinal: 12},
            {cor:'y', classe: 'yellow', casaPartida : 27, casaFinal: 25},
            {cor:'b', classe: 'blue',   casaPartida : 40, casaFinal: 38}
        ];

        this.jogadores = [];

        this.pistas = {
            pista: new Map(),
            final: new Map(),
            base: new Map(),
        }
        this.casasNormais = 52;
        this.casasFinais = 6;
        this.casasBase = 4;

        // definir as pistas normais de corrida
        for (var i = 1; i <= this.casasNormais; i++) {
            let seguranca = [1, 9, 14, 22, 27, 35, 40, 48].includes(i);
            this.pistas.pista.set(i, new Casa({tipo: 'normal', segura: seguranca}));
        }

        // definir os jogadores e as respectivas casas
        for (var i = 1; i <= this.jogadoresCount; i++) {
            this.jogadores.push(new Jogador(this.casaDosJogadores[i-1]));

            for (var j = 1; j <= this.casasFinais; j++) {
                this.pistas.final.set(j, new Casa({tipo: 'final', cor : this.casaDosJogadores[i-1].cor}));
            }

            for (var j = 1; j <= this.casasBase; j++) {
                let pipeta = new Pipeta({cor: this.casaDosJogadores[i-1].cor});
                this.pistas.base.set(j, new Casa({tipo: 'base', cor : this.casaDosJogadores[i-1].cor, 'pipetas' : pipeta }));
            }
        }
    }

    info(contexto) {
        switch(contexto) {
            case 1 : {
                console.log(this.jogadoresCount);
                console.log(this.casaDosJogadores);
                console.log(this.jogadores);
                break;
            }

            case 2: {
                console.log(this.pistas);
                break;
            }

            case 3: {
                console.log(this.casasNormais = 52, this.casasFinais = 6, this.casasBase = 4);
                break;
            }

            default : {
                console.log(this);
                break;
            }
        }
    }
}