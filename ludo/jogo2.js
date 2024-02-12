class Utils {
    static removerClasses(elemento, classe) {
        elemento.classList.remove.apply(
            elemento.classList,
            Array.from(elemento.classList).filter(v=>v.startsWith(classe))
        );
    }
}

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
    #estado;
    #valorActual;
    #rolando;
    constructor(options) {
        super();

        this.#event = new EventEmitter();
        this.#el = document.querySelector(options.el);
        this.#estado = {};
        this.reset();
        this.render();
    }

    rolar() {
        if (!this.consultaEstado('rolando')) {
            this.setEstado('rolando', true);
            this.setEstado('valorActual', droll.roll('1d6').total);

            this.render();

            this.setEstado('rolando', false);
        }
    }

    colorir(cor) {
        this.cor = cor;
    }

    reset() {
        this.setEstado('valorActual', 0);
        this.setEstado('rolando', false);

        this.render();
    }

    render() {
        this.#el.querySelector('.show').classList.remove('show');

        if (this.cor !== '') {
            const valorActual = this.consultaEstado('valorActual');
            Utils.removerClasses(this.#el, 'dice-');

            this.#el.classList.add("dice-" + this.cor);
            this.#el.querySelector('.face-' + valorActual).classList.add('show');
        }
    }

    consultaEstado(chave) {
        return this.#estado[chave];
    }
    setEstado(chave, valor) {
        this.#estado[chave] = valor;
        return true;
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
    #el;
    constructor(options) {
        super();
        this.#event = new EventEmitter();
        this.#el = document.querySelector(options.el);

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
                let pipeta = new Pipeta({cor: cor, numero: j});
                this.pistas.base.push(new Casa({tipo: 'base', cor : this.casaDosJogadores[i-1].cor, 'pipetas' : pipeta, numero: j }));
            }
        }

        this.render();
    }


    escolherPipeta(el) {
        console.log(el);
    }
    activarPipetas(cor) {
        this.#el.querySelectorAll(`.base.${cor} .token`).forEach(el => {
            el.classList.add('active');
        });
    }

    renderSafeZones() {
        let casas_seguras = this.pistas.pista.filter(casa => casa.segura);
        casas_seguras.forEach(casa => {
            document.querySelector(".race-" + casa.numero).classList.add("safe-zone");
        });
    }

    render() {
        this.renderSafeZones();
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

    consultarCDJ(chave, valor) {
        return this.casaDosJogadores.filter(jogador => jogador[chave] === valor)[0];
    }
}

class Jogo extends EventEmitter {
    #event;
    #estado = {};
    constructor(options) {
        super();

        this.dado = options.dado;
        this.tabuleiro = options.tabuleiro;

        this.#event = new EventEmitter();
        this.setEstado('jogadorActual', -1);
        this.setEstado('impedirJogada', false);
    }


    escolherPipeta(el) {
        this.tabuleiro.escolherPipeta(el);
        this.setEstado('impedirJogada', true);
    }

    activarPipetas() {
        this.setEstado('impedirJogada', true);
        const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];

        this.tabuleiro.activarPipetas(jogador.cor);
    }

    jogadorSeguinte() {
        let jogadorActual = this.consultaEstado('jogadorActual');
        jogadorActual += 1;

        if (jogadorActual == this.tabuleiro.jogadoresCount) {
            jogadorActual = 0;
        }
        this.setEstado('jogadorActual', jogadorActual);

        const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];

        //definir o layout do dado e renderizar
        this.dado.colorir(jogador.cor);
        this.dado.render();
    }

    vezSeguinte() {
        if (!this.consultaEstado('impedirJogada')) {
            const jogador = this.tabuleiro.jogadores[Number(this.consultaEstado('jogadorActual'))];

            //definir o layout do dado e rolar
            this.dado.colorir(jogador.cor);
            this.dado.rolar();

            this.emit('jogo.terminouturno', {
                jogadorActual: this.consultaEstado('jogadorActual'),
                dadoValorActual: this.dado.consultaEstado('valorActual')
            });
        }
        else {
            console.log('não pode jogar');
        }
    }

    consultaEstado(chave) {
        return this.#estado[chave];
    }
    setEstado(chave, valor) {
        this.#estado[chave] = valor;
        return true;
    }
}