// src/app/services/theme.service.ts
import { Injectable, signal, effect } from '@angular/core';

// Interfaz estricta para que no se te olvide ninguna imagen ni color
export interface PageThemeConfig {
  light: { color: string; bgHorizontal: string; bgVertical: string };
  dark: { color: string; bgHorizontal: string; bgVertical: string };
}

@Injectable({
  providedIn: 'root',
})
export class ThemeService {
  darkMode = signal<boolean>(false);

  // Guardamos la configuración actual de la página en la que estamos
  private currentTheme = signal<PageThemeConfig | null>(null);

  constructor() {
    // Este effect es la magia: se ejecuta solo cada vez que cambia el modo oscuro o la página
    // theme.service.ts
    effect(() => {
      const isDark = this.darkMode();
      const theme = this.currentTheme();

      // 1. Aplicamos el atributo de Bootstrap para que el resto de la web (tablas, textos) se adapte
      document.documentElement.setAttribute(
        'data-bs-theme',
        isDark ? 'dark' : 'light',
      );

      if (theme) {
        // 2. EXTRAEMOS LOS COLORES SEGÚN EL MODO ACTUAL
        // Si isDark es false (Modo Claro), cogemos el bloque 'light'
        // Si isDark es true (Modo Oscuro), cogemos el bloque 'dark'
        const colorActual = isDark ? theme.dark.color : theme.light.color;
        const colorInverso = isDark ? theme.light.color : theme.dark.color;

        // 3. INYECTAMOS LAS VARIABLES
        document.documentElement.style.setProperty(
          '--theme-color',
          colorActual,
        );
        document.documentElement.style.setProperty(
          '--inverse-theme-color',
          colorInverso,
        );

        // 4. AJUSTAMOS EL COLOR DEL TEXTO PARA CONTRASTE
        const isLightColor = this.isColorLight(colorActual);
        const headerTextColor = isLightColor ? '#212529' : '#f8f9fa'; // Oscuro si fondo claro, claro si fondo oscuro
        document.documentElement.style.setProperty(
          '--header-text',
          headerTextColor,
        );

        // 4. GESTIÓN DE IMÁGENES
        const configImg = isDark ? theme.dark : theme.light;
        document.documentElement.style.setProperty(
          '--bg-horizontal',
          `url('${configImg.bgHorizontal}')`,
        );
        document.documentElement.style.setProperty(
          '--bg-vertical',
          `url('${configImg.bgVertical}')`,
        );
      }
    });
  }

  // Función para determinar si un color es claro u oscuro
  private isColorLight(color: string): boolean {
    // Remover # si existe
    const hex = color.replace('#', '');
    
    // Convertir a RGB
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    
    // Calcular luminancia (fórmula estándar)
    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
    
    // Si > 0.5 es claro, sino oscuro
    return luminance > 0.5;
  }

  toggleDarkMode() {
    this.darkMode.update((v) => !v);
  }

  // El componente llama a esto en su ngOnInit
  setPageTheme(config: PageThemeConfig) {
    this.currentTheme.set(config);
  }

  // El componente llama a esto en su ngOnDestroy para limpiar
  resetPageTheme() {
    this.currentTheme.set(null);
    document.documentElement.style.removeProperty('--theme-color');
    document.documentElement.style.removeProperty('--inverse-theme-color');
    document.documentElement.style.removeProperty('--header-text');
    document.documentElement.style.removeProperty('--bg-horizontal');
    document.documentElement.style.removeProperty('--bg-vertical');
  }
}
