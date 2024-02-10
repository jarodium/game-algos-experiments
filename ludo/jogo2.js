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
        for (const chave in options) {
            if (options.hasOwnProperty(chave)) {
                this[chave] = options[chave];
            }
        }
    }
}

class Dado extends EventEmitter {
    #event;
    #el;
    #valorActual;
    constructor(options) {
        super();

        this.#event = new EventEmitter();
        this.#el = document.querySelector(options.el);
        this.reset();
        this.render();
    }

    rolar() {
        this.#valorActual = droll.roll('1d6');
        this.render();

        this.emit('rolado',{
            resultado : this.#valorActual
        });
    }

    colorir(cor) {
        this.cor = cor;
    }

    reset() {
        this.#valorActual = 0;
        this.render();
    }

    render() {
        this.#el.querySelector('.show').classList.remove('show');

        if (this.cor !== '') {
            this.#el.classList.add("dice-" + this.cor);
            this.#el.querySelector('.face-' + this.#valorActual).classList.add('show');
        }
    }
}

class Casa {
    constructor(options) {
        this.numero = options.numero;
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
            pista: [],
            final: [],
            base: [],
        }
        this.casasNormais = 52;
        this.casasFinais = 6;
        this.casasBase = 4;

        // definir as pistas normais de corrida
        for (var i = 1; i <= this.casasNormais; i++) {
            let seguranca = [1, 9, 14, 22, 27, 35, 40, 48].includes(i);
            this.pistas.pista.push(new Casa({tipo: 'normal', segura: seguranca, numero: i}));
        }

        // definir os jogadores e as respectivas casas
        for (var i = 1; i <= this.jogadoresCount; i++) {
            this.jogadores.push(new Jogador(this.casaDosJogadores[i-1]));
            let cor = this.casaDosJogadores[i-1].cor;

            for (var j = 1; j <= this.casasFinais; j++) {
                this.pistas.final.push(new Casa({tipo: 'final', cor : cor, numero: j}));
            }

            for (var j = 1; j <= this.casasBase; j++) {
                let pipeta = new Pipeta({cor: cor});
                this.pistas.base.push(new Casa({tipo: 'base', cor : this.casaDosJogadores[i-1].cor, 'pipetas' : pipeta, numero: j }));
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