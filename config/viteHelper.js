import path, { resolve } from 'path';
import { promises as fs } from 'fs';

export function generateRandomHash(length) {
    let result = '';
    const characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    for (let i = 0; i < length; i++) {
      result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}




  export function removeFilesPlugin() {
    return {
      name: 'remove-files',
      closeBundle: async () => {
        const distPath = resolve(__dirname, 'dist');
        const files = await fs.readdir(distPath);
  
        const imageFiles = files.filter(file =>
          ['.jpg', '.png', '.gif', '.webp', '.svg'].some(ext => file.endsWith(ext))
        );
  
        const deleteFilesPromises = imageFiles.map(file => fs.unlink(resolve(distPath, file)));
  
        const deleteFoldersPromises = ['assets', 'fonts'].map(async folder => {
          const folderPath = resolve(distPath, folder);
          try {
            await fs.rm(folderPath, { recursive: true });
          } catch (err) {
            if (err.code !== 'ENOENT') throw err; // Ignore error if folder does not exist
          }
        });
  
        await Promise.all([...deleteFilesPromises, ...deleteFoldersPromises]);
      }
    };
  }