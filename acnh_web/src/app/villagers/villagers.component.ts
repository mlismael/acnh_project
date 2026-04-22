// src/app/pages/villagers/villagers.component.ts
import { Component, inject, OnInit, OnDestroy } from '@angular/core';
import { ThemeService, PageThemeConfig } from '../services/theme.service';
import { NookipediaService } from '../services/nookipedia.service';
import { MOCK_VILLAGERS } from './villagers.mock';
import { TranslationService } from '../services/translation.service';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-villagers',
  standalone: true, // Asegúrate de tener esto si usas Angular moderno
  imports: [FormsModule],
  templateUrl: './villagers.component.html',
  styleUrl: './villagers.component.css',
})
export class VillagersComponent implements OnInit, OnDestroy {
  private themeService = inject(ThemeService);
  private nookipediaService = inject(NookipediaService);

  aldeanos: any[] = []; // Aquí se guarda lo que llega de la API
  paginaActual: number = 1;
  itemsPorPagina: number = 24;
  especies: string[] = [];

  ngOnInit() {
    this.especies = this.translationService.getAvailableSpecies();

    this.nookipediaService.getVillagers().subscribe({
      next: (data) => {
        // Ordenamos alfabéticamente por el nombre (que ya viene traducido del servicio)
        this.aldeanos = data.sort((a: any, b: any) => a.name.localeCompare(b.name));
      },
      error: (err) => {
        console.error('API Caída, cargando mocks...', err);
        // También ordenamos los Mocks por si acaso
        this.aldeanos = MOCK_VILLAGERS.sort((a: any, b: any) => a.name.localeCompare(b.name));
      },
    });

    const villagersTheme: PageThemeConfig = {
      light: {
        color: 'rgba(66, 195, 182, 0.333)',
        bgHorizontal: '/assets/ISMI2.jpg',
        bgVertical: '/assets/IMG_1967.JPG'
      },
      dark: {
        color: 'rgba(66, 195, 182, 1)',
        bgHorizontal: '/assets/ISMI.png',
        bgVertical: '/assets/img-1967-dark.png'
      }
    };

    // Aplicamos el tema
    this.themeService.setPageTheme(villagersTheme);
  }

  ngOnDestroy() {
    // Limpiamos al salir de la ruta
    this.themeService.resetPageTheme();
  }


  //PAGINADOR

  get totalPaginas(): number {
    // Usamos las variables "Aplicadas" para que coincida con lo que se ve en pantalla
    const filtrados = this.aldeanos.filter((v) => {
      const cumpleNombre = v.name
        .toLowerCase()
        .includes(this.nombreAplicado.toLowerCase());
      const cumpleEspecie =
        this.especieAplicada === '' || v.species === this.especieAplicada;
      return cumpleNombre && cumpleEspecie;
    });

    const total = Math.ceil(filtrados.length / this.itemsPorPagina);
    return total > 0 ? total : 1; // Evitamos que devuelva 0 páginas
  }

  cambiarPagina(nuevaPagina: number) {
    this.paginaActual = nuevaPagina;
    // Truco: scroll hacia arriba suave para que el usuario vea el principio de la nueva lista
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  //BUSCADOR

  // En tu VillagersComponent
  private translationService = inject(TranslationService);

  // Variables de modelo (lo que el usuario toca)
  filtroNombre: string = '';
  especieSeleccionada: string = '';

  // Variables de aplicación (lo que se filtra tras pulsar "Buscar")
  nombreAplicado: string = '';
  especieAplicada: string = '';

  buscar() {
    this.nombreAplicado = this.filtroNombre;
    this.especieAplicada = this.especieSeleccionada;
    this.paginaActual = 1;
  }

  get aldeanosAMostrar() {
    const filtrados = this.aldeanos.filter((v) => {
      const cumpleNombre = v.name
        .toLowerCase()
        .includes(this.nombreAplicado.toLowerCase());
      const cumpleEspecie =
        this.especieAplicada === '' || v.species === this.especieAplicada;
      return cumpleNombre && cumpleEspecie;
    });

    const inicio = (this.paginaActual - 1) * this.itemsPorPagina;
    return filtrados.slice(inicio, inicio + this.itemsPorPagina);
  }

  // ... No olvides actualizar también el totalPaginas con la misma lógica de filtrado
}
